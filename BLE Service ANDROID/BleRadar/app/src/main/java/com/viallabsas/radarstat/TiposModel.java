package com.viallabsas.radarstat;

public class TiposModel {


    private String tipoNombre;
    private String urlImage;
    private int IDTIPO;

    // creating getter and setter methods
    public String getTipoNombre() {
        return tipoNombre;
    }

    public String getUrlImage() {
        return urlImage;
    }

    public int getIDTIPO() {
        return IDTIPO;
    }

    public void setIDTIPO(int id) {
        this.IDTIPO = id;
    }

    public void setTipoNombre(String tipoNombre) {
        this.tipoNombre = tipoNombre;
    }

    public void setTipoImagen(String Imagen) {
        this.urlImage = Imagen;
    }

    public TiposModel(){

    }

    public TiposModel(Integer Idtipo,String tipoNombre,String urlImage) {

        this.IDTIPO = Idtipo;
        this.tipoNombre = tipoNombre;
        this.urlImage = urlImage;
    }


}
