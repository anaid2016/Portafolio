package com.viallabsas.radarstat;

import androidx.appcompat.app.AppCompatActivity;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;

import java.util.ArrayList;
import java.util.Arrays;

public class TiposActivity extends AppCompatActivity {


    Button btnaddtipo;
    ArrayList<String> itemlist = new ArrayList<>();
    ArrayAdapter<String> arrayAdaptertipo;
    ListView lv2;
    Integer listposition;

    private DBHandler dbHandler;
    private ArrayList<TiposModel> tiposModelArrayList;

    //Inicializando Lista ===========================================
    String[] tipos2 = new String[] {};

    public static final String EXTRA_NOMBRE = "";
    public static final String EXTRA_POSICION = "";


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_tipos);

        btnaddtipo = (Button) findViewById(R.id.button8);
        lv2 = (ListView) findViewById(R.id.listview4);


        //Referencia a base de datos ================================================================================
        dbHandler = new DBHandler(TiposActivity.this);

        //Realizando Consulta =======================================================================================
        tiposModelArrayList = dbHandler.selectTipos();

        // Creando una lista del vector de cadena para el textview ===================================================
        itemlist = new ArrayList<String>(Arrays.asList(tipos2));
        for(int i = 0; i < tiposModelArrayList.size(); i++){
            itemlist.add(tiposModelArrayList.get(i).getTipoNombre());
        }
        arrayAdaptertipo = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, itemlist);

        // DataBind ListView with items from ArrayAdapter
        lv2.setAdapter(arrayAdaptertipo);

        //evento para setonclic listener para listview
        lv2.setOnItemClickListener(SelectableTipo);

        btnaddtipo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                goAdd();
            }
        });


        lv2.setOnItemLongClickListener(new AdapterView.OnItemLongClickListener() {
            @Override
            public boolean onItemLongClick(AdapterView<?> arg0, View arg1,
                                           int pos, long id) {
                // TODO Auto-generated method stub

                Log.v("long clicked","pos: " + id);

                String valitem = arg0.getItemAtPosition(pos).toString().trim();

                AlertDialog.Builder adb = new AlertDialog.Builder(TiposActivity.this);
                adb.setTitle("Borrar?");
                adb.setMessage("Esta Seguro de Borrar el tipo:  " + valitem);
                final int positionToRemove = pos;
                adb.setNegativeButton("Cancel", null);
                adb.setPositiveButton("Ok", new AlertDialog.OnClickListener() {
                    public void onClick(DialogInterface dialog, int which) {
                        itemlist.remove(positionToRemove);
                        arrayAdaptertipo.notifyDataSetChanged();
                        dbHandler.borrarTipos(valitem);
                    }
                });
                adb.show();
                return true;
            }
        });
    }


    public void goAdd(){
        Intent i = new Intent(this, AddtipoActivity.class);
        startActivity(i);
    }

    public void goMod(String Position, String NombreTipo){
        Log.d("TIPO","VALITEM: "+NombreTipo);
        Intent i = new Intent(this, AddtipoActivity.class);
        i.putExtra("EXTRA_NOMBRE",NombreTipo);
        i.putExtra("EXTRA_POSICION",Position);
        startActivity(i);
    }


    private AdapterView.OnItemClickListener SelectableTipo = new AdapterView.OnItemClickListener() {
        @Override
        public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

            String valitem = parent.getItemAtPosition(position).toString().trim();
            listposition = position;
            goMod(listposition.toString(),valitem);

           /* AlertDialog.Builder adb = new AlertDialog.Builder(TiposActivity.this);
            adb.setTitle("Borrar?");
            adb.setMessage("Esta Seguro de Borrar el tipo:  " + valitem);
            final int positionToRemove = position;
            adb.setNegativeButton("Cancel", null);
            adb.setPositiveButton("Ok", new AlertDialog.OnClickListener() {
                public void onClick(DialogInterface dialog, int which) {
                    itemlist.remove(positionToRemove);
                    arrayAdaptertipo.notifyDataSetChanged();
                    dbHandler.borrarTipos(valitem);
                }
            });
            adb.show();*/

        }
    };

    @Override
    public void onBackPressed() {
        Intent intent;
        intent = new Intent(this, MainActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TOP);
        finish();
        startActivity(intent);
    }

}