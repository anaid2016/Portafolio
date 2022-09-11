package com.viallabsas.radarstat;

import androidx.appcompat.app.AppCompatActivity;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import java.util.ArrayList;
import java.util.Arrays;

public class SelectcarpetaActivity extends AppCompatActivity {


    //Para el listado de carpetas
    ArrayList<String> Carpetas = new ArrayList<>();
    ArrayAdapter<String> arrayAdapter4;
    ListView lv8;
    String[] carpeted = new String[] {};
    private DBHandler dbHandler;
    private ArrayList<CarpetasModel> carpetasModelArrayList;
    private int lastcarpeta;
    public static final String EXTRA_TEXT = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_selectcarpeta);


        //Cargando listview ===============================================
        lv8 = (ListView) findViewById(R.id.listview12);
        Carpetas = new ArrayList<>(Arrays.asList(carpeted));
        arrayAdapter4 = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, Carpetas);

        //Buscando dispositivo anteriormente seleccionado
        dbHandler = new DBHandler(SelectcarpetaActivity.this);

        //Realizando Consulta =======================================================================================
        carpetasModelArrayList = dbHandler.selectCarpetas();
        lastcarpeta = 1; //Aqui falta traerse la carpeta con el intent para cargarla desde la vista anterior


        for(int i = 0; i < carpetasModelArrayList.size(); i++){
            Carpetas.add(carpetasModelArrayList.get(i).getCapetaNombre());
        }

        // DataBind ListView with items from ArrayAdapter
        lv8.setAdapter(arrayAdapter4);

        //Agregando evento de seleccion =============================================================================
        lv8.setOnItemClickListener(Selectablecarpeta);

    }


    private AdapterView.OnItemClickListener Selectablecarpeta = new AdapterView.OnItemClickListener() {
        @Override
        public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

            String valitem = parent.getItemAtPosition(position).toString().trim();
            goReturn(valitem);

        }
    };


    private void goReturn(String valor){
        Intent i = new Intent(this, MedicionesActivity.class);
        i.putExtra(EXTRA_TEXT, valor);
        startActivity(i);
    }
}