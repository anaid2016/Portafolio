package com.viallabsas.radarstat;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.NotificationCompat;
import androidx.core.app.NotificationManagerCompat;
import androidx.core.content.FileProvider;

import android.app.Notification;
import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.os.WorkSource;
import android.view.View;

import java.io.File;
import java.io.FileOutputStream;
import java.util.ArrayList;

import org.apache.poi.hssf.usermodel.HSSFCell;
import org.apache.poi.hssf.usermodel.HSSFRow;
import org.apache.poi.hssf.usermodel.HSSFSheet;
import org.apache.poi.hssf.usermodel.HSSFWorkbook;



public class ReporteActivity extends AppCompatActivity {


    private ArrayList<MedicionesModel> medicionesModelList = new ArrayList<>();
    private String CHANNEL_ID="0";
    private String CHANEL_NAME="viallab";
    private String CHANEL_DESCRIPTION="notificacion app viallab";


    String folderPath2 =  Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_DOWNLOADS).toString();
    private File filePath = new File(folderPath2 + "/Demo.xls");


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reporte);
        createNotificationChannel();
        guardar();
    }

    public void guardar(){

        HSSFWorkbook hssfWorkbook = new HSSFWorkbook();
        HSSFSheet hssfSheet = hssfWorkbook.createSheet("Custom Sheet");

        HSSFRow hssfRow = hssfSheet.createRow(0);
        HSSFCell hssfCell = hssfRow.createCell(0);

        hssfCell.setCellValue("prueba 1");

        HSSFCell hssfCell2 = hssfRow.createCell(1);
        hssfCell2.setCellValue("prueba 2");

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

            openNotificacion();

        } catch (Exception e) {
            e.printStackTrace();
        }

    }


    private void openNotificacion(){

        Intent intent = openFile(this,filePath);
        PendingIntent pendingIntent = PendingIntent.getActivity(this, 0, intent, PendingIntent.FLAG_IMMUTABLE);

        NotificationCompat.Builder builder = new NotificationCompat.Builder(this, CHANNEL_ID)
                .setSmallIcon(R.drawable.icon5)
                .setContentTitle("My notification")
                .setContentText("Hello World!")
                .setPriority(NotificationCompat.PRIORITY_DEFAULT)
                // Set the intent that will fire when the user taps the notification
                .setContentIntent(pendingIntent)
                .setAutoCancel(true);

        NotificationManagerCompat notificationManager = NotificationManagerCompat.from(this);

        // notificationId is a unique int for each notification that you must define
        int notificationId=1;
        notificationManager.notify(notificationId, builder.build());
    }

    /*Creando canal de Notificacion*/
    private void createNotificationChannel() {
        // Create the NotificationChannel, but only on API 26+ because
        // the NotificationChannel class is new and not in the support library
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            CharSequence name = CHANEL_NAME;
            String description = CHANEL_DESCRIPTION;
            int importance = NotificationManager.IMPORTANCE_DEFAULT;
            NotificationChannel channel = new NotificationChannel(CHANNEL_ID, name, importance);
            channel.setDescription(description);
            // Register the channel with the system; you can't change the importance
            // or other notification behaviors after this
            NotificationManager notificationManager = getSystemService(NotificationManager.class);
            notificationManager.createNotificationChannel(channel);
        }
    }


    public static Intent openFile(Context context, File file) {



        String fileName = file.getName();

        String extension = fileName.substring(fileName.lastIndexOf(".") + 1);


        String  type = "application/vnd.ms-excel";

       /*if (getAttachmentType(fileName) == AttachmentType.IMAGE) {
            type = "image/*";
        } else if (getAttachmentType(fileName) == AttachmentType.AUDIO) {
            type = "audio/*";
        } else if (getAttachmentType(fileName) == AttachmentType.VIDEO) {
            type = "video/*";
        } else if (getAttachmentType(fileName) == AttachmentType.WORD) {
            type = "application/msword";
        } else if (getAttachmentType(fileName) == AttachmentType.EXCEL) {
            type = "application/vnd.ms-excel";
        } else if (getAttachmentType(fileName) == AttachmentType.POWERPOINT) {
            type = "application/vnd.ms-powerpoint";
        } else if (getAttachmentType(fileName) == AttachmentType.TXT) {
            type = "text/*";
        }*/

        //Uri path = Uri.fromFile(file);
        Uri path = FileProvider.getUriForFile(context, context.getApplicationContext().getPackageName() + ".provider", file);
        Intent intent = new Intent(Intent.ACTION_VIEW);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        intent.addFlags(Intent.FLAG_GRANT_READ_URI_PERMISSION);
        Intent chooser = Intent.createChooser(intent, "Se ha descargado el archivo de Reporte");
        intent.setDataAndType(path, type);
        return chooser;
    }


}