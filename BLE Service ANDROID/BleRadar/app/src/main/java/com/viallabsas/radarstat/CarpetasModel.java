package com.viallabsas.radarstat;

public class CarpetasModel {

    private String carpetaNombre;
    private int IDCARPETA;

    // creating getter and setter methods
    public String getCapetaNombre() {
        return carpetaNombre;
    }

    public int getIdcarpeta() {
        return IDCARPETA;
    }

    public void setIdcarpeta(int id) {
        this.IDCARPETA = id;
    }

    public CarpetasModel(String carpetaNombre) {
        this.carpetaNombre = carpetaNombre;
    }

}
