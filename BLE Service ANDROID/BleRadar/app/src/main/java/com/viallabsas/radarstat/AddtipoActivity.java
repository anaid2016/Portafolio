package com.viallabsas.radarstat;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Toast;

public class AddtipoActivity extends AppCompatActivity {

    Button btnagregar;
    Button btncancelar;
    ImageButton btnaddimage;
    EditText txttipo;
    String urlstring;
    private DBHandler dbHandler;
    int SELECT_PICTURE = 200;
    String nombreTipo=null;
    String posicionTipo=null;
    TiposModel tipoModify =   new TiposModel();


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_addtipo2);
        dbHandler = new DBHandler(AddtipoActivity.this);

        Intent intent = getIntent();
        nombreTipo = intent.getStringExtra("EXTRA_NOMBRE");
        posicionTipo = intent.getStringExtra("EXTRA_POSICION");


        if (!TextUtils.isEmpty(nombreTipo)) {
            tipoModify = dbHandler.selectoneTipo(nombreTipo);

            Uri myImege = Uri.parse(tipoModify.getUrlImage());
            ImageView imageView = findViewById(R.id.imageView);
            imageView.setImageURI(myImege);

            urlstring = tipoModify.getUrlImage();

        }

        btnagregar = (Button) findViewById(R.id.button9);
        btncancelar = (Button) findViewById(R.id.button10);
        btnaddimage = (ImageButton) findViewById(R.id.imageButton);
        txttipo = findViewById(R.id.txt3);
        txttipo.setText(nombreTipo);


        btnagregar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                addTipo();
            }
        });


        btncancelar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                goBack();
            }
        });


        btnaddimage.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                imageChooser();
            }
        });

    }


    private void addTipo() {

        if (TextUtils.isEmpty(txttipo.getText().toString())) {
            Toast.makeText(AddtipoActivity.this, "Nombre no puede ser vacio!", Toast.LENGTH_SHORT).show();
            return;
        }

        if (TextUtils.isEmpty(urlstring)) {
            Toast.makeText(AddtipoActivity.this, "Seleccione una Imagen", Toast.LENGTH_SHORT).show();
            return;
        }

        try {
            Boolean agregarTipo = dbHandler.addTipos(txttipo.getText().toString(),urlstring);
            if(agregarTipo){
                goBack();
            }else{
                Toast.makeText(AddtipoActivity.this, "Error al Ingresar Tipo.", Toast.LENGTH_SHORT).show();
            }

        }catch (Exception e){
            Toast.makeText(AddtipoActivity.this, "Error al Ingresar Tipo, Tipo Repetido o Campos Vacios!", Toast.LENGTH_SHORT).show();
        }

    }


    public void goBack() {
        Intent i = new Intent(this, TiposActivity.class);
        startActivity(i);
    }

    void imageChooser() {

        // create an instance of the
        // intent of the type image
        Intent i = new Intent();
        i.setType("image/*");
        i.setAction(Intent.ACTION_GET_CONTENT);

        // pass the constant to compare it
        // with the returned requestCode
        startActivityForResult(Intent.createChooser(i, "Select Picture"), SELECT_PICTURE);
    }

    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (resultCode == RESULT_OK) {

            // compare the resultCode with the
            // SELECT_PICTURE constant
            if (requestCode == SELECT_PICTURE) {
                // Get the url of the image from data
                Uri selectedImageUri = data.getData();

                if (null != selectedImageUri) {

                    ImageView imageView = findViewById(R.id.imageView);
                    imageView.setImageURI(selectedImageUri);
                    urlstring = selectedImageUri.toString();
                }
            }
        }
    }

}