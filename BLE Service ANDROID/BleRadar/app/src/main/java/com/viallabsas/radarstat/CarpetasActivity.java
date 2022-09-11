package com.viallabsas.radarstat;

import androidx.appcompat.app.AppCompatActivity;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.ViewConfiguration;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Arrays;

public class CarpetasActivity extends AppCompatActivity {

    ArrayList<String> tipolist = new ArrayList<>();
    ArrayAdapter<String> arrayAdapter;
    EditText editText;
    Button btnoperar;
    ListView lv;
    Integer listposition;
    String lastCarpeta;


    private DBHandler dbHandler;
    private long mLastClickTime;
    private ArrayList<CarpetasModel> carpetasModelArrayList;

    //Inicializando Lista ===========================================
    String[] tipos = new String[] {};

    @Override
    protected void onCreate(Bundle savedInstanceState) {


        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_carpetas);

        // Referencia del listview y del boton a la vista ============================================================
        lv = (ListView) findViewById(R.id.listview3);
        btnoperar = (Button) findViewById(R.id.button7);
        editText = findViewById(R.id.txt2);


        //Referencia a base de datos ================================================================================
        dbHandler = new DBHandler(CarpetasActivity.this);

        //Realizando Consulta =======================================================================================
        carpetasModelArrayList = dbHandler.selectCarpetas();

        // Creando una lista del vector de cadena para el textview ===================================================
        tipolist = new ArrayList<String>(Arrays.asList(tipos));
        for(int i = 0; i < carpetasModelArrayList.size(); i++){
            tipolist.add(carpetasModelArrayList.get(i).getCapetaNombre());
        }

        // Creando arrayadapter para la lista
        arrayAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, tipolist);


        // DataBind ListView with items from ArrayAdapter
        lv.setAdapter(arrayAdapter);

        //evento para setonclic listener para listview
        lv.setOnItemClickListener(SelectableItem);

        btnoperar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                addCarpeta();

                // Add new Items to List
                //tiposlist.add("Tipo 3");
                //tiposlist.add("Tipo 4");
                //arrayAdapter.notifyDataSetChanged();

            }
        });


        lv.setOnItemLongClickListener(new AdapterView.OnItemLongClickListener() {
            @Override
            public boolean onItemLongClick(AdapterView<?> arg0, View arg1,
                                           int pos, long id) {
                // TODO Auto-generated method stub

                Log.v("long clicked","pos: " + id);

                String valitem = arg0.getItemAtPosition(pos).toString().trim();

                AlertDialog.Builder adb=new AlertDialog.Builder(CarpetasActivity.this);
                adb.setTitle("Borrar?");
                adb.setMessage("Esta Seguro de Borrar la Carpeta  " + valitem);
                final int positionToRemove = pos;
                adb.setNegativeButton("Cancel", null);
                adb.setPositiveButton("Ok", new AlertDialog.OnClickListener() {
                    public void onClick(DialogInterface dialog, int which) {
                        tipolist.remove(positionToRemove);
                        arrayAdapter.notifyDataSetChanged();

                        dbHandler.borrarCarpeta(valitem);
                    }});
                adb.show();

                return true;
            }
        });
    }


    private void addCarpeta() {

        try {

            String txtboton  = btnoperar.getText().toString();
            Boolean ingresar = false;

            if (TextUtils.isEmpty(editText.getText().toString())) {
                Toast.makeText(CarpetasActivity.this, "Nombre no puede ser vacio!", Toast.LENGTH_SHORT).show();
                return;
            }

            if( txtboton.equals("AGREGAR") ) {
                ingresar =dbHandler.addNewCarpetas(editText.getText().toString());
            }else {
                ingresar =dbHandler.modifyCarpeta(editText.getText().toString(),lastCarpeta);
            }


            if(ingresar){

                if( txtboton.equals("AGREGAR") ) {
                    tipolist.add(editText.getText().toString());
                }else{
                    tipolist.set(listposition,editText.getText().toString());
                }
                Toast.makeText(CarpetasActivity.this, "Carpeta Agregada", Toast.LENGTH_SHORT).show();
            }else{
                Toast.makeText(CarpetasActivity.this, "Error al ingregar Carpeta", Toast.LENGTH_SHORT).show();
            }


        }catch (Exception e){
            Toast.makeText(CarpetasActivity.this, "Carpeta ya Existente!", Toast.LENGTH_SHORT).show();
        }

        editText.setText("");
        arrayAdapter.notifyDataSetChanged();
    }



    private AdapterView.OnItemClickListener SelectableItem = new AdapterView.OnItemClickListener() {
        @Override
        public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

            long currTime = System.currentTimeMillis();

            if (currTime - mLastClickTime < ViewConfiguration.getDoubleTapTimeout()) {
                onItemDoubleClick(parent, view, position, id);
            }
            mLastClickTime = currTime;


        }
    };


    public void onItemDoubleClick(AdapterView<?> parent, View view, int position, long l) {

         String valitem = parent.getItemAtPosition(position).toString().trim();
         listposition = position;
         lastCarpeta = valitem;
         editText.setText(valitem);
         arrayAdapter.notifyDataSetChanged();

        //Cambiando nombre de boton =======================================
        btnoperar.setText("MODIFICAR");
    }




}