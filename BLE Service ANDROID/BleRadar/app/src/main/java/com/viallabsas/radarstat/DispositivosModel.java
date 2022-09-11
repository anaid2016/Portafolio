package com.viallabsas.radarstat;

public class DispositivosModel {

    private String dispositivoNombre;
    private String dispositivoMac;
    private int IDDISPOSITIVO;


    public String getDispositivoNombre() {
        return dispositivoNombre;
    }

    public String getDispositivoMac(){return dispositivoMac;}

    public int getIDDISPOSITIVO() {
        return IDDISPOSITIVO;
    }

    public void setIDDISPOSITIVO(int id) {
        this.IDDISPOSITIVO = id;
    }

    public DispositivosModel(String mac,String nombre) {
        this.dispositivoNombre = nombre;
        this.dispositivoMac = mac;
    }

}
