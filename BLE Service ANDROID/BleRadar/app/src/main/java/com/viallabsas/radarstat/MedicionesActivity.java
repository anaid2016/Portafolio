package com.viallabsas.radarstat;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.core.content.res.ResourcesCompat;

import android.Manifest;
import android.app.AlertDialog;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothGatt;
import android.bluetooth.BluetoothGattCallback;
import android.bluetooth.BluetoothGattCharacteristic;
import android.bluetooth.BluetoothGattDescriptor;
import android.bluetooth.BluetoothGattService;
import android.bluetooth.BluetoothManager;
import android.content.BroadcastReceiver;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.ServiceConnection;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.os.IBinder;
import android.provider.Settings;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.InputStream;
import java.io.UnsupportedEncodingException;
import java.text.DateFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.UUID;

public class MedicionesActivity extends AppCompatActivity {

    private DBHandler dbHandler;
    private ArrayList<TiposModel> tiposModelArrayList;
    private ArrayList<ConfiguracionesModel> configuracionesModelArrayList;
    private ArrayList<MedicionesModel> medicionesModelList = new ArrayList<>();
    private Drawable icon;
    ImageButton btnselcarpeta;
    private String carpeta=null;
    private String tipo=null;
    private String address = "none";
    private boolean setautoguardado;
    private BluetoothAdapter bluetoothAdapter;
    private static final int REQUEST_ENABLE_BT = 1;
    private String TAG = "MEDICIONES";
    private BluetoothGatt gatt;
    private boolean reconect=false;
    private static final int STATE_DISCONNECTED = 0;
    private static final int STATE_CONNECTING = 1;
    private static final int STATE_CONNECTED = 2;
    private int connectionState = STATE_DISCONNECTED;
    private BluetoothGattCharacteristic mRXCharacteristic;

    private UUID SERVICE_UUID_P1 = convertFromInteger(0XFFE0);
    private UUID ALARMA_CHARACTERISTICA_NOTIFY = convertFromInteger(0XFFE4);
    private UUID ALARMA_USER_DESCRIPTOR_NOTIFY = convertFromInteger(0x2902);

    public final static String ACTION_DATA_AVAILABLE ="com.viallab.ACTION_DATA_AVAILABLE";
    public final static String EXTRA_DATA ="com.viallab.EXTRA_DATA";
    public final static String ACTION_GATT_CONNECTED ="com.viallab.ACTION_GATT_CONNECTED";
    public final static String ACTION_GATT_DISCONNECTED = "com.viallab.ACTION_GATT_DISCONNECTED";
    public final static String ACTION_GATT_SERVICES_DISCOVERED = "com.viallab.ACTION_GATT_SERVICES_DISCOVERED";

    final Handler handler = new Handler();
    final int delay = 3000;

    CheckBox autoguardado;
    private Runnable mRunnable;

    private String vel1 = "0";
    private String vel2 = "0";
    private String vel3 = "0";
    private String vel4 = "0";
    public boolean conectado=false;
    public String metrica="km";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mediciones);

        Intent intent = getIntent();
        carpeta = intent.getStringExtra(SelectcarpetaActivity.EXTRA_TEXT);


        if(carpeta == null){
            Toast.makeText(MedicionesActivity.this, "Seleccione Carpeta!", Toast.LENGTH_SHORT).show();
        }else{
            TextView TextLabel = (TextView) findViewById(R.id.textView3);
            TextLabel.setText("CARPETA: "+carpeta);
        }

        //0. Amarrando a la base de datos ====================================================
        dbHandler = new DBHandler(MedicionesActivity.this);

        //2. Creando instancias para el ble =================================================
        isBLESupported();

        //Revisando servicios BLE =========================================================================
        final BluetoothManager bluetoothManager = (BluetoothManager) getSystemService(Context.BLUETOOTH_SERVICE);
        bluetoothAdapter = bluetoothManager.getAdapter();
        habilitaBle();

        //1. Obteniendo MAC del equipo seleccionado =========================================
        ArrayList<DispositivosModel> dispositivosModelArrayList = dbHandler.selectDispositivons();
        address="none";
        for(int i = 0; i < dispositivosModelArrayList.size(); i++){
            if(i==0){
                address = dispositivosModelArrayList.get(i).getDispositivoMac().toString();


            }
        }
        Log.d("TAG","ADDRESS:"+address);


        //5. Creando botones dinamicos =======================================================
        createButtons();



        //6. Habilitando boton para seleccion de carpeta ===================================
        /*btnselcarpeta = (ImageButton) findViewById(R.id.imageButton2);
        btnselcarpeta.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                goSelectcarpeta();
            }
        });*/


        //7. Adecuando autoguardado =================================================
        autoguardado = (CheckBox)findViewById(R.id.checkBox);
        autoguardado.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                if(autoguardado.isChecked())
                {
                    setautoguardado = true;
                    dbHandler.addConfiguracion("v");
                }
                else
                {
                    setautoguardado = false;
                    dbHandler.addConfiguracion("f");
                }

            }
        });


        //Detectando valor de base de datos ===============================================
        ArrayList<ConfiguracionesModel> configuracionesModelArrayList = dbHandler.selectConfiguraciones();
        for(int i = 0; i < configuracionesModelArrayList.size(); i++){
            if(i==0){
                if(configuracionesModelArrayList.get(i).getVal1().equals("v")){
                    autoguardado.setChecked(true);
                    setautoguardado = true;
                }else{
                    autoguardado.setChecked(false);
                    setautoguardado = false;
                }

            }
        }


        //Conectado dispositivo ============================================================
        ConectarBle();


    }

    /*Verificando Soporte BLE*/
    public void isBLESupported() {
        if (!getPackageManager().hasSystemFeature(PackageManager.FEATURE_BLUETOOTH_LE)) {
            Toast.makeText(MedicionesActivity.this, "Error ble no soportado!", Toast.LENGTH_SHORT).show();
        }
    }

    /*Habilita Bluetooth en caso que este deshabilitado*/
    private void habilitaBle(){
        Toast.makeText(MedicionesActivity.this, "habilitando ble!", Toast.LENGTH_SHORT).show();
        if (bluetoothAdapter == null || !bluetoothAdapter.isEnabled()) {
            Intent enableBtIntent = new Intent(BluetoothAdapter.ACTION_REQUEST_ENABLE);
            startActivityForResult(enableBtIntent, REQUEST_ENABLE_BT);
        }
    }


    /*
     Conectar Bluetooth
     */
    private void ConectarBle(){

        Log.e(TAG,"hola intento conectar");
        close();

        if(address == "none"){
            Toast.makeText(MedicionesActivity.this, "No existe dispositivo Seleccionado!", Toast.LENGTH_SHORT).show();
            return;
        }

        if (bluetoothAdapter == null || address == null) {
            Log.i(TAG, " 21 BluetoothAdapter not initialized or unspecified address.");
            return;
        }

        final BluetoothDevice device = bluetoothAdapter.getRemoteDevice(address);
        if (device == null) {
            Log.i(TAG, " 23 Device not found.  Unable to connect.");
        }

        gatt = device.connectGatt(this, true, gattCallback);

        Log.i (TAG, "24 Trying to create a new connection.");


        reconect=true;
        connectionState = STATE_CONNECTING;
    }


    public void close() {
        if (gatt == null) {
            return;
        }
        gatt.close();
        gatt = null;
    }


    private final BluetoothGattCallback gattCallback =
            new BluetoothGattCallback() {

                String intentAction;
                @Override
                public void onConnectionStateChange(BluetoothGatt gatt, int status, int newState) {
                    if (newState == STATE_CONNECTED){

                        Log.e(TAG,"Accede al gatta");
                        gatt.discoverServices();
                        conectado = true;

                        mRunnable = new Runnable() {
                            public void run() {
                                System.out.println("myHandler: here!"); // Do your work here
                                saveMediciones();
                                handler.postDelayed(this, delay);
                            }
                        };
                        handler.postDelayed(mRunnable, delay);

                    }else if(newState == STATE_DISCONNECTED){
                        conectado = false;
                        Log.e(TAG,"Desconecta al gatta");
                    }

                    Log.e("MainGat"," que llega de state "+newState);
                }

                @Override
                public void onServicesDiscovered(BluetoothGatt gatt, int status){
                    Log.e(TAG,"ENTRO A DISCOVERY");
                    final BluetoothGattService Service = gatt.getService(SERVICE_UUID_P1);
                    if(Service != null){

                        BluetoothGattCharacteristic characteristicN = Service.getCharacteristic(ALARMA_CHARACTERISTICA_NOTIFY);
                        gatt.setCharacteristicNotification(characteristicN, true);
                        BluetoothGattDescriptor descriptor =  characteristicN.getDescriptor(ALARMA_USER_DESCRIPTOR_NOTIFY);
                        if (descriptor != null) {
                            descriptor.setValue(BluetoothGattDescriptor.ENABLE_NOTIFICATION_VALUE);
                        }
                        gatt.writeDescriptor(descriptor);
                    }

                }

                @Override
                public void onCharacteristicChanged(BluetoothGatt gatt, BluetoothGattCharacteristic characteristic) {
                    Log.d(TAG,"Cambio caracteristica");
                    super.onCharacteristicChanged(gatt, characteristic);
                    byte[] newValue = characteristic.getValue();
                    String salida = bytesToHexStr(newValue);
                    Log.d(TAG,"CHANGE:"+salida);

                    if(salida.length()%2!=0){
                        System.err.println("Invlid hex string.");
                        return;
                    }

                    StringBuilder builder = new StringBuilder();

                    for (int i = 0; i < salida.length(); i = i + 2) {
                        // Step-1 Split the hex string into two character group
                        String s = salida.substring(i, i + 2);
                        // Step-2 Convert the each character group into integer using valueOf method
                        int n = Integer.valueOf(s, 16);
                        // Step-3 Cast the integer value to char
                        builder.append((char)n);
                    }

                    processdata(builder.toString());

                    //System.out.println("Hex = " + salida);
                    //System.out.println("ASCII = " + builder.toString());


                  //  String salida2 = hexToAscii(salida);
                    //String result = convert(newValue);
                    //System.out.println(result);
                 //   Log.d(TAG,"CHANGE:"+salida2);
                   // System.out.println(salida2);
                }
            };



    /*Funcion para enviar la solicitud de servicios
     */
    public UUID convertFromInteger(int i) {
        final long MSB = 0x0000000000001000L;
        final long LSB = 0x800000805f9b34fbL;
        long value = i & 0xFFFFFFFF;
        return new UUID(MSB | (value << 32), LSB);
    }


    public void processdata(String dataget){


        Date fechahora = Calendar.getInstance().getTime();
        String fechaformateada = DateFormat.getDateTimeInstance(DateFormat.SHORT, DateFormat.MEDIUM).format(fechahora);
        String cadena=dataget.substring(1,(dataget.length()-1));
        String[] velocidades = cadena.split(";");
        double factor = 1;

        if(metrica.equals("km")){
            factor = 1.609344;
        }


        //Adquiriendo velocidades =================================================================================
        if ( velocidades.length < 2) {

            if(setautoguardado){
                 Toast.makeText(MedicionesActivity.this, "Radar No permite Proceso de Autoguardado", Toast.LENGTH_SHORT).show();
                 autoguardado.setChecked(false);
                 setautoguardado = false;
                dbHandler.addConfiguracion("f");
            }

            vel1 =  Double.toString((Integer.valueOf(velocidades[0])*factor)).split("\\.")[0];

        }else if(velocidades.length < 5){
             vel1 = Double.toString(Integer.valueOf(velocidades[0])*factor).split("\\.")[0];
             vel2 = Double.toString(Integer.valueOf(velocidades[1])*factor).split("\\.")[0];
             vel3 = Double.toString(Integer.valueOf(velocidades[2])*factor).split("\\.")[0];
             vel4 = Double.toString(Integer.valueOf(velocidades[3])*factor).split("\\.")[0];
        } else{
             vel1 = "--";
        }

        TextView TextVelocidad = (TextView) findViewById(R.id.textView2);
        TextVelocidad.setText(vel1+"["+metrica+"]");

        /*Para guardado con false ver Crearbotones opcion clic*/
        if(setautoguardado){

            if(carpeta == null){
                Toast.makeText(MedicionesActivity.this, "Seleccione Carpeta!", Toast.LENGTH_SHORT).show();
            }else{
                tipo="0";
                medicionesModelList.add(new MedicionesModel(fechaformateada,vel1,vel2,vel3,vel4,tipo,carpeta));
                //dbHandler.addMediciones(fechaformateada,vel1,vel2,vel3,vel4,tipo,carpeta);
            }
        }

    }


    private void saveMediciones(){

        for(int i=0; i<medicionesModelList.size();i++){

            if(dbHandler.addMediciones(medicionesModelList.get(i).getFecha(),
                    medicionesModelList.get(i).getVel1(),
                    medicionesModelList.get(i).getVel2(),
                    medicionesModelList.get(i).getVel3(),
                    medicionesModelList.get(i).getVel4(),
                    medicionesModelList.get(i).getTipo(),
                    medicionesModelList.get(i).getCarpeta() )){

                medicionesModelList.remove(i);
            };


        }

    }





    //=================================================================================================================================

    public void goSelectcarpeta(){
        Intent i = new Intent(this, SelectcarpetaActivity.class);
        startActivity(i);
    }

    private void createButtons(){

        //1. Leyendo tipos =============================================================
        tiposModelArrayList = dbHandler.selectTipos();
        LinearLayout layout = (LinearLayout)  findViewById(R.id.lybuttons);

        for(int i = 0; i < tiposModelArrayList.size(); i++){

            Log.d("Mediciones","Imagen:"+tiposModelArrayList.get(i).getUrlImage().toString());
            Log.d("Mediciones","IDTIPO:"+tiposModelArrayList.get(i).getIDTIPO());
            Uri profileuri = Uri.parse(tiposModelArrayList.get(i).getUrlImage().toString());

            Button imgButton = new Button(this);
            imgButton.setText(tiposModelArrayList.get(i).getTipoNombre().toString());
            imgButton.setId(tiposModelArrayList.get(i).getIDTIPO());
            /*imgButton.setGravity(Gravity.CENTER | Gravity.LEFT);


            InputStream is;
            try {
                is = this.getContentResolver().openInputStream( profileuri );
                BitmapFactory.Options options=new BitmapFactory.Options();
                options.inSampleSize = 10;
                Bitmap preview_bitmap=BitmapFactory.decodeStream(is,null,options);

                Drawable icon = new BitmapDrawable(getResources(),preview_bitmap);

            } catch (FileNotFoundException e) {
                //set default image from the button
                icon = ResourcesCompat.getDrawable(getResources(), R.drawable.icon1, null);
            }



            imgButton.setBackground(icon);*/
            layout.addView(imgButton);


            imgButton.setOnClickListener(new View.OnClickListener() {
                public void onClick(View view) {
                    Log.d("Mediciones","ID BOTON:"+imgButton.getId());
                    tipo = imgButton.getText().toString();

                    if(!setautoguardado && conectado){
                        if(carpeta == null){
                            Toast.makeText(MedicionesActivity.this, "Seleccione Carpeta!", Toast.LENGTH_SHORT).show();
                        }else{
                            Date fechahora = Calendar.getInstance().getTime();
                            String fechaformateada = DateFormat.getDateTimeInstance(DateFormat.SHORT, DateFormat.MEDIUM).format(fechahora);

                            medicionesModelList.add(new MedicionesModel(fechaformateada,vel1,vel2,vel3,vel4,tipo,carpeta));
                           // dbHandler.addMediciones(fechaformateada,vel1,vel2,vel3,vel4,tipo,carpeta);
                        }
                    }


                }
            });

        }


    }



    /*
    De hex to String
     */
    public static String bytesToHexStr(byte[] bytes){
        StringBuilder stringBuilder = new StringBuilder("");
        if (bytes == null || bytes.length <= 0) {
            return null;
        }
        for (int i = 0; i < bytes.length; i++) {
            int v = bytes[i] & 0xFF;
            String hv = Integer.toHexString(v);
            if (hv.length() < 2) {
                stringBuilder.append("" + 0 + hv);
            }else{
                stringBuilder.append("" + hv);
            }
        }
        return stringBuilder.toString();
    }


    //Permisos ==========================================================================================
    private void showGPSDisabledAlertToUser() {

        AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(this);
        alertDialogBuilder.setMessage(R.string.gps_permisos)
                .setCancelable(false)
                .setPositiveButton(R.string.abrir_gps,
                        (dialog, id) -> {
                            Intent callGPSSettingIntent = new Intent(
                                    Settings.ACTION_LOCATION_SOURCE_SETTINGS);
                            startActivity(callGPSSettingIntent);
                        });

        alertDialogBuilder.setNegativeButton(R.string.cancelar, (dialog, id) -> dialog.cancel());

        AlertDialog alert = alertDialogBuilder.create();
        alert.show();

    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu, menu);
        return true;
    }


    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_name) {
            Log.d(TAG,"probando cambios");
            goSelectcarpeta();
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    public void onBackPressed() {
        close();
        handler.removeCallbacks(mRunnable);

        Intent intent;
        intent = new Intent(this, MainActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TOP);
        finish();
        startActivity(intent);
    }

    @Override
    public void onDestroy() {

        close();
        handler.removeCallbacks(mRunnable);
        super.onDestroy();

    }



}