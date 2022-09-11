package com.viallabsas.radarstat;

import androidx.appcompat.app.AppCompatActivity;

import android.Manifest;
import android.app.AlertDialog;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothManager;
import android.bluetooth.le.BluetoothLeScanner;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.le.ScanCallback;
import android.bluetooth.le.ScanResult;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.location.LocationManager;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.provider.Settings;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Arrays;

public class ConexionActivity extends AppCompatActivity {

    private BluetoothAdapter bluetoothAdapter;
    private boolean scanning;
    private Handler handler = new Handler();
    private static final int REQUEST_ENABLE_BT = 1;
    BluetoothLeScanner bluetoothLeScanner;
    Button btnscan;

    //Para el listado ============================
    ArrayList<String> blelist = new ArrayList<>();
    ArrayAdapter<String> arrayAdapterble;
    ListView lv5;
    String[] deviceble = new String[] {};
    private DBHandler dbHandler;
    private ArrayList<DispositivosModel> dispositivosModelArrayList;
    String lastmac;

    // Stops scanning after 10 seconds.
    private static final long SCAN_PERIOD = 10000;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_conexion);


        //Anclando para el listview
        lv5 = (ListView) findViewById(R.id.listview5);
        blelist = new ArrayList<String>(Arrays.asList(deviceble));
        arrayAdapterble = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, blelist);
        Button btnscan =  (Button) findViewById(R.id.button6);

        //Buscando dispositivo anteriormente seleccionado
        dbHandler = new DBHandler(ConexionActivity.this);

        //Realizando Consulta =======================================================================================
        dispositivosModelArrayList = dbHandler.selectDispositivons();
        lastmac="none";
        for(int i = 0; i < dispositivosModelArrayList.size(); i++){
            if(i==0){
                lastmac = dispositivosModelArrayList.get(i).getDispositivoMac().toString();
            }
        }

        // DataBind ListView with items from ArrayAdapter
        lv5.setAdapter(arrayAdapterble);


        //evento para setonclic listener para listview
        lv5.setOnItemClickListener(SelectableBle);


        final BluetoothManager bluetoothManager = (BluetoothManager) getSystemService(Context.BLUETOOTH_SERVICE);
        bluetoothAdapter = bluetoothManager.getAdapter();
        bluetoothLeScanner = bluetoothAdapter.getBluetoothLeScanner();


        if (bluetoothAdapter == null || !bluetoothAdapter.isEnabled()) {
            Toast.makeText(this, R.string.error_bluetooth_not_supported, Toast.LENGTH_SHORT).show();
            finish();
            return;
        }

        scanLeDevice();

        btnscan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                scanLeDevice();
            }
        });
    }


    private void scanLeDevice() {
        if (!scanning) {
            // Stops scanning after a predefined scan period.
            handler.postDelayed(new Runnable() {
                @Override
                public void run() {
                    scanning = false;
                    bluetoothLeScanner.stopScan(leScanCallback);
                    changecolor();
                }
            }, SCAN_PERIOD);

            scanning = true;
            bluetoothLeScanner.startScan(leScanCallback);
        } else {
            scanning = false;
            bluetoothLeScanner.stopScan(leScanCallback);
        }
    }



    // Device scan callback.
    private ScanCallback leScanCallback =
            new ScanCallback() {
                @Override
                public void onScanResult(int callbackType, ScanResult result) {
                    super.onScanResult(callbackType, result);
                    String findData;
                    if(TextUtils.isEmpty(result.getDevice().getName())){
                        findData = "No Name - "+result.getDevice().getAddress();
                    }else{
                        findData = result.getDevice().getName()+" - "+result.getDevice().getAddress();
                    }
                    if(blelist.contains(findData) == false){
                        blelist.add(findData);

                    }

                    arrayAdapterble.notifyDataSetChanged();

            }
    };


    private void changecolor(){
        lv5.setAdapter(new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, blelist) {
            @Override
            public View getView(int position, View convertView, ViewGroup parent) {
                View row = super.getView(position, convertView, parent);
                Log.d("CONEXION: ","MAC INSERTADA:"+lastmac+"::"+getItem(position).toString());

                String[] valselect = getItem(position).split("-");
                if(valselect[1].trim().equals(lastmac))
                {
                    // do something change color
                    row.setBackgroundColor (Color.RED); // some color
                }
                else
                {
                    // default state
                    row.setBackgroundColor (Color.WHITE); // default coloe
                }
                return row;
            }
        });
    }

    private AdapterView.OnItemClickListener SelectableBle = new AdapterView.OnItemClickListener() {
        @Override
        public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

            String valitem = parent.getItemAtPosition(position).toString().trim();
            //listposition = position;
            //editText.setText(valitem);
            //arrayAdapter.notifyDataSetChanged();

            //Cambiando nombre de boton =======================================
            //btnoperar.setText("MODIFICAR");

            AlertDialog.Builder adb=new AlertDialog.Builder(ConexionActivity.this);
            adb.setTitle("Dispositivos");
            adb.setMessage("Radar Selecionado:  " + valitem);
            final int positionToRemove = position;
            adb.setNegativeButton("Cancel", null);
            adb.setPositiveButton("Ok", new AlertDialog.OnClickListener() {
                public void onClick(DialogInterface dialog, int which) {
                  Log.d("CONEXION","Selecciono radar: "+valitem);
                  String[] partes = valitem.split("-");
                  dbHandler.addDispositivos(partes[1].trim().toString(),partes[0].trim().toString());
                  lastmac = partes[1].trim().toString();
                  changecolor();

                }});
            adb.show();


        }
    };
}