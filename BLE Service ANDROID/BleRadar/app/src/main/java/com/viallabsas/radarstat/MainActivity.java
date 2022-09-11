package com.viallabsas.radarstat;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.app.NotificationCompat;
import androidx.core.app.NotificationManagerCompat;
import androidx.core.content.FileProvider;

import android.Manifest;
import android.app.AlertDialog;
import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.provider.Settings;
import android.util.Log;
import android.view.View;

import org.apache.poi.hssf.usermodel.HSSFCell;
import org.apache.poi.hssf.usermodel.HSSFRow;
import org.apache.poi.hssf.usermodel.HSSFSheet;
import org.apache.poi.hssf.usermodel.HSSFWorkbook;

import java.io.File;
import java.io.FileOutputStream;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Locale;

public class MainActivity extends AppCompatActivity {


    /*Para Descarga de Excel ==============================*/

    /*Notificacion*/
    private String CHANNEL_ID="0";
    private String CHANEL_NAME="viallab";
    private String CHANEL_DESCRIPTION="notificacion app viallab";

    /*FilePath*/
    String folderPath2 =  Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_DOWNLOADS).toString();
    private File filePath = new File(folderPath2 + "/Reporte.xls");

    /*Traiendo BD*/
    private DBHandler dbHandler;
    private ArrayList<MedicionesModel> medicionesModelArrayList;

    /*Permisos ================================================+*/
    private static String[] PERMISSIONS_STORAGE = {
            Manifest.permission.READ_EXTERNAL_STORAGE,
            Manifest.permission.WRITE_EXTERNAL_STORAGE,
            Manifest.permission.ACCESS_FINE_LOCATION,
            Manifest.permission.ACCESS_COARSE_LOCATION,
            Manifest.permission.ACCESS_LOCATION_EXTRA_COMMANDS,
            Manifest.permission.BLUETOOTH_SCAN,
            Manifest.permission.BLUETOOTH_CONNECT,
            Manifest.permission.BLUETOOTH_PRIVILEGED
    };
    private static String[] PERMISSIONS_LOCATION = {
            Manifest.permission.ACCESS_FINE_LOCATION,
            Manifest.permission.ACCESS_COARSE_LOCATION,
            Manifest.permission.ACCESS_LOCATION_EXTRA_COMMANDS,
            Manifest.permission.BLUETOOTH_SCAN,
            Manifest.permission.BLUETOOTH_CONNECT,
            Manifest.permission.BLUETOOTH_PRIVILEGED
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        //Permiso de Localización ===========================================================================
        LocationManager locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            Log.e("Operar:","Permiso de GPS");
            if (!locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
                showGPSDisabledAlertToUser();
            }
        }

        //Referencia a base de datos ================================================================================
        dbHandler = new DBHandler(MainActivity.this);
        medicionesModelArrayList = dbHandler.selectMediciones();


        checkPermissions();


    }


    /*Verificando Permisos */
    /* FUNCTION PARA ALERTA USUARIO GPS*/
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


    private void checkPermissions(){
        int permission1 = ActivityCompat.checkSelfPermission(this, Manifest.permission.WRITE_EXTERNAL_STORAGE);
        int permission2 = ActivityCompat.checkSelfPermission(this, Manifest.permission.BLUETOOTH_SCAN);
        if (permission1 != PackageManager.PERMISSION_GRANTED) {
            // We don't have permission so prompt the user
            ActivityCompat.requestPermissions(
                    this,
                    PERMISSIONS_STORAGE,
                    1
            );
        } else if (permission2 != PackageManager.PERMISSION_GRANTED){
            ActivityCompat.requestPermissions(
                    this,
                    PERMISSIONS_LOCATION,
                    1
            );
        }
    }



    public void goConexion(View view) {
        Intent intent = new Intent(this, ConexionActivity.class);
        startActivity(intent);
    }

    public void goMediciones(View view) {
        Intent intent = new Intent(this, MedicionesActivity.class);
        startActivity(intent);
    }

    public void goTipos(View view) {
        Intent intent = new Intent(this, TiposActivity.class);
        startActivity(intent);
    }

    public void goCarpetas(View view) {
        Intent intent = new Intent(this, CarpetasActivity.class);
        startActivity(intent);
    }


    public void goReportes(View view) {
        //Intent intent = new Intent(this, ReporteActivity.class);
        //startActivity(intent);

        createNotificationChannel();
        guardar();
    }



    /*Ejecutando Notificacion y Reporte*/
    public void guardar(){

        //filepath ==================================================================================================
        SimpleDateFormat df = new SimpleDateFormat("yyyyMMddhhmmss", Locale.getDefault());
        String time = df.format(new Date());
        String filename = "/Reporte"+time+".xls";
        filePath = new File(folderPath2 + filename);

        HSSFWorkbook hssfWorkbook = new HSSFWorkbook();
        HSSFSheet hssfSheet = hssfWorkbook.createSheet("Reporte");

        HSSFRow hssfRow = hssfSheet.createRow(0);

        HSSFCell hssfCell = hssfRow.createCell(0);
        hssfCell.setCellValue("Fecha Creación");

        HSSFCell hssfCell2 = hssfRow.createCell(1);
        hssfCell2.setCellValue("Carpeta");

        HSSFCell hssfCell3 = hssfRow.createCell(2);
        hssfCell3.setCellValue("Categoria");

        HSSFCell hssfCell4 = hssfRow.createCell(3);
        hssfCell4.setCellValue("Tipo Detectado");

        HSSFCell hssfCell5 = hssfRow.createCell(4);
        hssfCell5.setCellValue("Velocidad Promedio");

        HSSFCell hssfCell6 = hssfRow.createCell(5);
        hssfCell6.setCellValue("Velocidad Maxima");

        HSSFCell hssfCell7 = hssfRow.createCell(6);
        hssfCell7.setCellValue("Ultima Velocidad");

        for(int i=0;i<medicionesModelArrayList.size();i++){

            hssfRow = hssfSheet.createRow(i+1);

            hssfCell = hssfRow.createCell(0);
            hssfCell.setCellValue(medicionesModelArrayList.get(i).getFecha());

            hssfCell = hssfRow.createCell(1);
            hssfCell.setCellValue(medicionesModelArrayList.get(i).getCarpeta());

            hssfCell = hssfRow.createCell(2);
            hssfCell.setCellValue(medicionesModelArrayList.get(i).getTipo());

            hssfCell = hssfRow.createCell(3);
            hssfCell.setCellValue(medicionesModelArrayList.get(i).getVel4());

            hssfCell = hssfRow.createCell(4);
            hssfCell.setCellValue(medicionesModelArrayList.get(i).getVel1());

            hssfCell = hssfRow.createCell(5);
            hssfCell.setCellValue(medicionesModelArrayList.get(i).getVel2());

            hssfCell = hssfRow.createCell(6);
            hssfCell.setCellValue(medicionesModelArrayList.get(i).getVel3());

        }


        try {
            if (!filePath.exists()){
                filePath.createNewFile();
            }

            FileOutputStream fileOutputStream= new FileOutputStream(filePath);
            hssfWorkbook.write(fileOutputStream);

            if (fileOutputStream!=null){
                fileOutputStream.flush();
                fileOutputStream.close();
            }

            dbHandler.borrarMediciones();
            openNotificacion(filePath);

        } catch (Exception e) {
            e.printStackTrace();
        }

    }


    private void openNotificacion(File fileopen){

        Log.d("MAIN","File to open: "+fileopen.getName());

        //Intent intent = openFile(this,fileopen);

        String  type = "application/vnd.ms-excel";
        Uri path = FileProvider.getUriForFile(this, this.getApplicationContext().getPackageName() + ".provider", fileopen);
        Intent intent = new Intent(Intent.ACTION_VIEW);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_GRANT_READ_URI_PERMISSION);
        intent.setDataAndType(path, type);

        PendingIntent pendingIntent = PendingIntent.getActivity(this, 0, intent, PendingIntent.FLAG_MUTABLE);

        NotificationCompat.Builder builder = new NotificationCompat.Builder(this, CHANNEL_ID)
                .setSmallIcon(R.drawable.icon5)
                .setContentTitle("Reporte Generado")
                .setContentText("Se ha descargado el Reporte :"+fileopen.getName())
                .setPriority(NotificationCompat.PRIORITY_DEFAULT)
                .setContentIntent(pendingIntent)
                .setAutoCancel(true);

        NotificationManagerCompat notificationManager = NotificationManagerCompat.from(this);

        // notificationId is a unique int for each notification that you must define
        int notificationId = (int) System.currentTimeMillis();
        notificationManager.notify(notificationId, builder.build());
    }

    /*Creando canal de Notificacion*/
    private void createNotificationChannel() {


        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            CharSequence name = CHANEL_NAME;
            String description = CHANEL_DESCRIPTION;
            int importance = NotificationManager.IMPORTANCE_DEFAULT;
            NotificationChannel channel = new NotificationChannel(CHANNEL_ID, name, importance);
            channel.setDescription(description);


            NotificationManager notificationManager = getSystemService(NotificationManager.class);
            notificationManager.createNotificationChannel(channel);
        }

    }


    public static Intent openFile(Context context, File file) {

        Log.d("MAIN","FILE 2"+file.getName());
        String  type = "application/vnd.ms-excel";
        Uri path = FileProvider.getUriForFile(context, context.getApplicationContext().getPackageName() + ".provider", file);
        Intent intent = new Intent(Intent.ACTION_VIEW);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        intent.addFlags(Intent.FLAG_GRANT_READ_URI_PERMISSION);
        intent.setDataAndType(path, type);
        Intent chooser = Intent.createChooser(intent, "Se ha descargado el archivo de Reporte");
        return chooser;
    }
}