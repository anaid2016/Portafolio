package com.viallabsas.radarstat;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteConstraintException;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteException;
import android.database.sqlite.SQLiteOpenHelper;
import android.text.TextUtils;
import android.util.Log;

import java.util.ArrayList;

public class DBHandler extends SQLiteOpenHelper {

    // creando variable para la base de datos, este es el nombre de la base de datos
    private static final String DB_NAME = "statradar";

    // version de la base de datos
    private static final int DB_VERSION = 5;

    // below variable is for our table name.
    private static final String TABLE_NAME = "tipos";
    private static final String TABLE_NAME1 = "carpetas";
    private static final String TABLE_NAME2 = "dispositivos";
    private static final String TABLE_NAME3 = "mediciones";
    private static final String TABLE_NAME4 = "configuraciones";


    // creating a constructor for our database handler.
    public DBHandler(Context context) {
        super(context, DB_NAME, null, DB_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {

        //Tabla tipos
        String query = "CREATE TABLE " + TABLE_NAME + " ("
                + "IDTIPO INTEGER PRIMARY KEY AUTOINCREMENT, "
                + "NOMBRETIPO TEXT UNIQUE,"
                + "IMAGENTIPO TEXT )";

        //Tabla carpetas
        String query2 = "CREATE TABLE " + TABLE_NAME1 + " ("
                + "IDCARPETA INTEGER PRIMARY KEY AUTOINCREMENT, "
                + "CARPETA TEXT UNIQUE )";

        //Tabla dispositivos
        String query3 = "CREATE TABLE " + TABLE_NAME2 + " ("
                + "IDDISPOSITIVO INTEGER PRIMARY KEY AUTOINCREMENT, "
                + "MAC TEXT,"
                + "NOMBRE TEXT )";


        //Tabla mediciones ===================pendiente revisar en otra app por dentro
        String query4 = "CREATE TABLE " + TABLE_NAME3 + " ("
                + "IDMEDICION INTEGER PRIMARY KEY AUTOINCREMENT, "
                + "FECHA TEXT,"
                + "VEL1 TEXT,"
                + "VEL2 TEXT,"
                + "VEL3 TEXT,"
                + "VEL4 TEXT,"
                + "TIPO TEXT,"
                + "CARPETA TEXT )";


        //Tabla mediciones ===================pendiente revisar en otra app por dentro
        String query5 = "CREATE TABLE " + TABLE_NAME4 + " ("
                + "IDCONFIGURAION INTEGER PRIMARY KEY AUTOINCREMENT, "
                + "VAL1 TEXT,"
                + "VAL2 TEXT,"
                + "VAL3 TEXT,"
                + "VAL4 TEXT )";

        db.execSQL(query);
        db.execSQL(query2);
        db.execSQL(query3);
        db.execSQL(query4);
        db.execSQL(query5);

    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        // this method is called to check if the table exists already.
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_NAME);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_NAME1);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_NAME2);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_NAME3);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_NAME4);
        onCreate(db);
    }


    //Metodos propios INSERT,SELECT,COUNT ***********************************************************************************

    /***********************************************************CARPETAS *********************************************************/
    public boolean addNewCarpetas(String carpetaNombre) {

       if (TextUtils.isEmpty(carpetaNombre)) {
            return false;
        }

        SQLiteDatabase db = this.getWritableDatabase();
        try{
            ContentValues values = new ContentValues();
            values.put("CARPETA", carpetaNombre.toUpperCase());
            db.insertOrThrow(TABLE_NAME1, null, values);
        }catch (SQLiteConstraintException e){
            Log.d("DBHANDLER","Carpeta Repetida");
            return false;
        }
        db.close();
        return true;
    }

    public boolean modifyCarpeta(String carpetaNombre,String lastcarpeta){

        if (TextUtils.isEmpty(carpetaNombre) || TextUtils.isEmpty(lastcarpeta)) {
            return false;
        }

        SQLiteDatabase db = this.getWritableDatabase();

        try{

            ContentValues cv = new ContentValues();
            cv.put("CARPETA", carpetaNombre);
            db.update(TABLE_NAME1,cv,"CARPETA=?",new String[]{lastcarpeta.toUpperCase()});

        }catch (SQLiteConstraintException e){
            Log.d("DBHANDLER","Carpeta Repetida");
            return false;
        }

        db.close();
        return true;
    }

    public void borrarCarpeta(String carpetaNombre){

        SQLiteDatabase db = this.getWritableDatabase();
        db.delete(TABLE_NAME1, "CARPETA=?", new String[]{carpetaNombre.toUpperCase()});
        db.close();

    }

    // we have created a new method for reading all the courses.
    public ArrayList<CarpetasModel> selectCarpetas() {
        // on below line we are creating a
        // database for reading our database.
        SQLiteDatabase db = this.getReadableDatabase();

        // on below line we are creating a cursor with query to read data from database.
        Cursor cursorCourses = db.rawQuery("SELECT * FROM " + TABLE_NAME1, null);

        // on below line we are creating a new array list.
        ArrayList<CarpetasModel> courseModalArrayList = new ArrayList<>();

        // moving our cursor to first position.
        if (cursorCourses.moveToFirst()) {
            do {
                // on below line we are adding the data from cursor to our array list.
                courseModalArrayList.add(new CarpetasModel(cursorCourses.getString(1)));
            } while (cursorCourses.moveToNext());
            // moving our cursor to next.
        }
        // at last closing our cursor
        // and returning our array list.
        cursorCourses.close();
        return courseModalArrayList;
    }

    /*************************************************TIPOS ********************************************/


    public boolean addTipos(String tipoNombre,String urlimage) {

        if (TextUtils.isEmpty(tipoNombre)) {
            return false;
        }

        if (TextUtils.isEmpty(urlimage)) {
            return false;
        }

        SQLiteDatabase db = this.getWritableDatabase();
        try{

            ContentValues values = new ContentValues();
            values.put("NOMBRETIPO", tipoNombre.toUpperCase());
            values.put("IMAGENTIPO", urlimage);
            db.insertOrThrow(TABLE_NAME, null, values);

        }catch (SQLiteConstraintException e){
            Log.d("DBHANDLER","Carpeta Repetida");
            return false;
        }
        db.close();
        return true;
    }

    public void borrarTipos(String tipoNombre){

        SQLiteDatabase db = this.getWritableDatabase();
        db.delete(TABLE_NAME, "NOMBRETIPO=?", new String[]{tipoNombre.toUpperCase()});
        db.close();

    }


    public ArrayList<TiposModel> selectTipos() {
        // on below line we are creating a
        // database for reading our database.
        SQLiteDatabase db = this.getReadableDatabase();

        // on below line we are creating a cursor with query to read data from database.
        Cursor cursorTipos = db.rawQuery("SELECT * FROM " + TABLE_NAME, null);

        // on below line we are creating a new array list.
        ArrayList<TiposModel> tiposModalArrayList = new ArrayList<>();

        // moving our cursor to first position.
        if (cursorTipos.moveToFirst()) {
            do {
                // on below line we are adding the data from cursor to our array list.
                tiposModalArrayList.add(new TiposModel(cursorTipos.getInt(0),cursorTipos.getString(1),cursorTipos.getString(2)));
            } while (cursorTipos.moveToNext());
            // moving our cursor to next.
        }
        // at last closing our cursor
        // and returning our array list.
        cursorTipos.close();
        return tiposModalArrayList;
    }


    public TiposModel selectoneTipo(String tipoNombre) {
        TiposModel u = new TiposModel();
        SQLiteDatabase db = this.getReadableDatabase();

        Cursor c = db.rawQuery("select * from " + TABLE_NAME+" where NOMBRETIPO =?", new String[]{tipoNombre.toUpperCase()});
        if (c.moveToLast()) {
            u.setIDTIPO(c.getInt(0));
            u.setTipoNombre(c.getString(1));
            u.setTipoImagen(c.getString(2));
        }else {
            Log.e("error not found", "user can't be found or database empty");
        }
        c.close();
        db.close();
        return u;
    }




    /************************************Para Dispositivos **************************************/

    public boolean addDispositivos(String macdispositivo,String nombredispositivo) {

        if (TextUtils.isEmpty(macdispositivo)) {
            return false;
        }

        if (TextUtils.isEmpty(nombredispositivo)) {
            return false;
        }

        try{

            ContentValues values = new ContentValues();
            values.put("MAC", macdispositivo);
            values.put("NOMBRE", nombredispositivo.toUpperCase());

            //1, borrando la posicion actual  =============================================
            this.borrarDispositivos();

            //2. Agregando dispositivo nuevo ==============================================
            SQLiteDatabase db2 = this.getWritableDatabase();
            db2.insertOrThrow(TABLE_NAME2, null, values);
            db2.close();

        }catch (SQLiteConstraintException e){
            Log.d("DBHANDLER","Dispositivo Guardado");
            return false;
        }

        return true;
    }

    public void borrarDispositivos(){

        SQLiteDatabase db = this.getWritableDatabase();
        String deleteall = "DELETE FROM "+TABLE_NAME2+" ";
        db.execSQL(deleteall);
        db.close();

    }

    public ArrayList<DispositivosModel> selectDispositivons() {
        // on below line we are creating a
        // database for reading our database.
        SQLiteDatabase db = this.getReadableDatabase();

        // on below line we are creating a cursor with query to read data from database.
        Cursor cursorTipos = db.rawQuery("SELECT * FROM " + TABLE_NAME2, null);

        // on below line we are creating a new array list.
        ArrayList<DispositivosModel> dispositionsModalArrayList = new ArrayList<>();

        // moving our cursor to first position.
        if (cursorTipos.moveToFirst()) {
            do {
                // on below line we are adding the data from cursor to our array list.
                dispositionsModalArrayList.add(new DispositivosModel(cursorTipos.getString(1),cursorTipos.getString(2)));
            } while (cursorTipos.moveToNext());
            // moving our cursor to next.
        }
        // at last closing our cursor
        // and returning our array list.
        cursorTipos.close();
        return dispositionsModalArrayList;
    }


    /**************************************Para Mediciones **********************************************/
    public boolean addMediciones(String fecha,String vel1, String vel2, String vel3, String vel4, String tipo, String carpeta) {

        if (TextUtils.isEmpty(fecha)) {
            return false;
        }

        if (TextUtils.isEmpty(tipo)) {
            return false;
        }

        try{

            ContentValues values = new ContentValues();
            values.put("FECHA", fecha);
            values.put("VEL1", vel1);
            values.put("VEL2", vel2);
            values.put("VEL3", vel3);
            values.put("VEL4", vel4);
            values.put("TIPO",tipo);
            values.put("CARPETA", carpeta);

            Log.d("DBHANDLER","Guarda N");
            //2. Agregando dispositivo nuevo ==============================================
            SQLiteDatabase db2 = this.getWritableDatabase();
            db2.insertOrThrow(TABLE_NAME3, null, values);
            db2.close();

        }catch (SQLiteConstraintException e){
            Log.d("DBHANDLER","Error al Guardar Mediciones");
            return false;
        }

        return true;
    }

    public void borrarMediciones(){

        SQLiteDatabase db = this.getWritableDatabase();
        String deleteall = "DELETE FROM "+TABLE_NAME3+" ";
        db.execSQL(deleteall);
        db.close();

    }


    public ArrayList<MedicionesModel> selectMediciones() {
        // on below line we are creating a
        // database for reading our database.
        SQLiteDatabase db = this.getReadableDatabase();

        // on below line we are creating a cursor with query to read data from database.
        Cursor cursorTipos = db.rawQuery("SELECT * FROM " + TABLE_NAME3, null);

        // on below line we are creating a new array list.
        ArrayList<MedicionesModel> medicionesModalArrayList = new ArrayList<>();

        // moving our cursor to first position.
        if (cursorTipos.moveToFirst()) {
            do {
                // on below line we are adding the data from cursor to our array list.
                medicionesModalArrayList.add(new MedicionesModel(cursorTipos.getString(1),
                        cursorTipos.getString(2),
                        cursorTipos.getString(3),
                        cursorTipos.getString(4),
                        cursorTipos.getString(5),
                        cursorTipos.getString(6),
                        cursorTipos.getString(7)));
            } while (cursorTipos.moveToNext());
            // moving our cursor to next.
        }
        // at last closing our cursor
        // and returning our array list.
        cursorTipos.close();
        return medicionesModalArrayList;
    }



    /**************************************CONFIGURACIONES ******************************************/
    public boolean addConfiguracion(String val1) {



        try{

            ContentValues values = new ContentValues();
            values.put("VAL1", val1);

            //1, borrando la posicion actual  =============================================
            this.borrarConfiguraciones();

            //2. Agregando dispositivo nuevo ==============================================
            SQLiteDatabase db2 = this.getWritableDatabase();
            db2.insertOrThrow(TABLE_NAME4, null, values);
            db2.close();

        }catch (SQLiteConstraintException e){
            Log.d("DBHANDLER","Dispositivo Guardado");
            return false;
        }

        return true;
    }

    public void borrarConfiguraciones(){

        SQLiteDatabase db = this.getWritableDatabase();
        String deleteall = "DELETE FROM "+TABLE_NAME4+" ";
        db.execSQL(deleteall);
        db.close();

    }


    public ArrayList<ConfiguracionesModel> selectConfiguraciones() {
        // on below line we are creating a
        // database for reading our database.
        SQLiteDatabase db = this.getReadableDatabase();

        // on below line we are creating a cursor with query to read data from database.
        Cursor cursorTipos = db.rawQuery("SELECT * FROM " + TABLE_NAME4, null);

        // on below line we are creating a new array list.
        ArrayList<ConfiguracionesModel> configuracionesModalArrayList = new ArrayList<>();

        // moving our cursor to first position.
        if (cursorTipos.moveToFirst()) {
            do {
                // on below line we are adding the data from cursor to our array list.
                configuracionesModalArrayList.add(new ConfiguracionesModel(cursorTipos.getString(1)));
            } while (cursorTipos.moveToNext());
            // moving our cursor to next.
        }
        // at last closing our cursor
        // and returning our array list.
        cursorTipos.close();
        return configuracionesModalArrayList;
    }
}
