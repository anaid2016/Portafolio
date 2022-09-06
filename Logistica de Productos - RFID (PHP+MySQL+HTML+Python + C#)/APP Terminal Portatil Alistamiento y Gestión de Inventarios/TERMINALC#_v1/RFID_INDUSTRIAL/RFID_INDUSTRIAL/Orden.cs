using System;
using System.Linq;
using System.Collections.Generic;
using System.Text;

namespace RFID_INDUSTRIAL
{
    class Orden
    {
       public int Id { get; set; }
       public string nopedido { get; set; }
       //public string nombre { get; set; }
       //public string codbarras { get; set; }
       //public string RFID { get; set; }
       //public string ubicacion { get; set; }
       //public int cantidadpedida { get; set; }

       public Orden() { }

       public Orden(int pId, string pnopedido)

       {
           this.Id = pId;
           this.nopedido = pnopedido;
           //this.nombre = pnombre;
           //this.codbarras = pcodbarras;
           //this.RFID = pRFID;
           //this.cantidadpedida = pcantidadpedida;
           //this.ubicacion = pubicacion;

               
       }
    }
}
