package com.viallabsas.radarstat;

/*
IDMEDICION INTEGER PRIMARY KEY AUTOINCREMENT, "
                + "FECHA TEXT,"
                + "VEL1 TEXT,"
                + "VEL2 TEXT,"
                + "VEL3 TEXT,"
                + "VEL4 TEXT,"
                + "TIPO TEXT,"
                + "CATEGORIA TEXT,"
                + "CARPETA TEXT

 */
public class MedicionesModel {

    public int idmedicion;
    public String fecha;
    public String vel1;
    public String vel2;
    public String vel3;
    public String vel4;
    public String tipo;
    public String categoria;
    public String carpeta;


    // creando los metodos ===================================================================
    public String getFecha() {
        return fecha;
    }

    public String getVel1() {
        return vel1;
    }

    public String getVel2() {
        return vel2;
    }

    public String getVel3() {
        return vel3;
    }

    public String getVel4() {
        return vel4;
    }

    public String getTipo() {
        return tipo;
    }

    public String getCarpeta() {return carpeta;}

    public MedicionesModel(String fecha, String vel1, String vel2, String vel3, String vel4, String typo,  String carpet) {
        this.fecha = fecha;
        this.vel1 = vel1;
        this.vel2 = vel2;
        this.vel3 = vel3;
        this.vel4 = vel4;
        this.tipo = typo;
        this.carpeta = carpet;
    }

}
