using System;
using System.Linq;
using System.Collections.Generic;
using System.Text;

namespace RFID_INDUSTRIAL
{
    class Ordenc2
    {
       public int Id2 { get; set; }
       public int Id3 { get; set; }
       //public string nombre2 { get; set; }
       public string codbarras2 { get; set; }
       public string RFID2 { get; set; }
       public string ubicacion2 { get; set; }

       public Ordenc2() { }

       public Ordenc2(int pId3,int pId2, string pnorden, string pnombre2, string pcodbarras2, string pRFID2, int pcantubicar2,string pubicacion2)

       {
           this.Id2 = pId2;
           //this.norden = pnorden;
           //this.nombre2 = pnombre2;
           this.codbarras2 = pcodbarras2;
           this.RFID2 = pRFID2;
           //this.cantubicar2 = pcantubicar2;
           this.ubicacion2 = pubicacion2;

               
       }
    }
}
