using System;
using System.Linq;
using System.Collections.Generic;
using System.Text;
using System.Threading;
using MySql.Data.MySqlClient;

namespace RFID_INDUSTRIAL
{
    class Ordenes
    {
        public static int conectar()
        {
            MySqlConnection conexion = Class1.ObtenerConexion();
            conexion.Close();
            return 1;
        
        }

        public static List<Orden> Buscar()
        {
            List<Orden> _lista = new List<Orden>();
            MySqlConnection conexion = Class1.ObtenerConexion();

            MySqlCommand _comando = new MySqlCommand(String.Format(
           "Select Id,nopedido from com_pedidos where estado_id=3"), conexion);
            MySqlDataReader _reader = _comando.ExecuteReader();
            while (_reader.Read())
            {
                Orden pOrdenes = new Orden();
                pOrdenes.Id = _reader.GetInt32(0);
                pOrdenes.nopedido = _reader.GetString(1);

                _lista.Add(pOrdenes);
            }
            conexion.Close();
            return _lista;
        }


        public static Orden ObtenerOrden(int pId)
        {
            Orden pOrden = new Orden();
            MySqlConnection conexion = Class1.ObtenerConexion();

            MySqlCommand _comando = new MySqlCommand(String.Format("SELECT Select Id,nopedido from com_pedidos where estado_id=3 and Id={0}", pId), conexion);
            MySqlDataReader _reader = _comando.ExecuteReader();
            while (_reader.Read())
            {
                pOrden.Id = _reader.GetInt32(0);
                pOrden.nopedido = _reader.GetString(1);

            }

            conexion.Close();
            return pOrden;

        }


        //Buscando los productos de un Pedido===============================================================================

        public static List<Orden2> ObtenerPedidoProducto(string Idp)
        {

            List<Orden2> _lista = new List<Orden2>();
            MySqlConnection conexion = Class1.ObtenerConexion();

            MySqlCommand _comando = new MySqlCommand(String.Format("SELECT com_productospedido.Id,com_productospedido.pedido_id,com_productos.nombre,com_productos.codbarras,com_inventario.RFID,CONCAT(com_areas_almacenamiento.referencia,'-',com_arraybodega.estante,'-',com_arraybodega.nivel) as bodega,com_productospedido.cantidadpedida FROM com_productospedido LEFT JOIN com_estadopedido ON com_estadopedido.Id=com_productospedido.estado_id LEFT JOIN com_inventario ON com_inventario.Id=com_productospedido.inventario_id LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id LEFT JOIN com_areas_almacenamiento ON com_areas_almacenamiento.Id=com_arraybodega.areas_almacenamiento_id WHERE pedido_id={0}", Idp), conexion);

            MySqlDataReader _reader = _comando.ExecuteReader();
            while (_reader.Read())
            {
                Orden2 pOrdenes2 = new Orden2();
                pOrdenes2.Id = _reader.GetInt32(0);
                //pOrdenes2.nopedido = _reader.GetString(1);
                pOrdenes2.codbarras = _reader.GetString(3);
                pOrdenes2.RFID = _reader.GetString(4);
                pOrdenes2.ubicacion = _reader.GetString(5);
                pOrdenes2.cantidadpedida = _reader.GetInt32(6);

                _lista.Add(pOrdenes2);
            }
            conexion.Close();
            return _lista;

        }

        //Guardando Encontrados en la Base de Datos==========================================================
        
        public static int GuardaPedido(string cadenaRFID,string pedidochange,string idpedido)
        {
            int retorno = 0;
            MySqlConnection conexion = Class1.ObtenerConexion();
    
            MySqlCommand _comando = new MySqlCommand(String.Format("UPDATE com_productospedido SET estado_id=7 WHERE Id in ({0})", cadenaRFID), conexion);
            retorno = _comando.ExecuteNonQuery();

            if (pedidochange == "2")
            {
                MySqlCommand _comando2 = new MySqlCommand(String.Format("UPDATE com_pedidos SET estado_id=7 WHERE Id={0}",idpedido), conexion);
                retorno = _comando2.ExecuteNonQuery();

            }
            
            conexion.Close();
            return retorno;

        }


        //Guardando Inventario Realizado para posterior revision ==============================================

        public static int GuardarInventario(string cadenaRFID2, string estante)
        {
            int retorno = 0;
            string[] sprfid = cadenaRFID2.Split(',');
            string cadenaf="";
            string sqlb = "";
            foreach (string word in sprfid)
	        {
	           cadenaf += "("+word+",'"+estante+"'),";
	        }

            int total2 = cadenaf.Length;
            string cadenaf2 = cadenaf.Substring(0, total2 - 1);

            if (cadenaf2 != "")
            {
                sqlb = "INSERT IGNORE INTO com_invterminal (RFID,arraybodega_id) VALUES " + cadenaf2 + "";
                MySqlConnection conexion = Class1.ObtenerConexion();
                MySqlCommand _comando = new MySqlCommand(String.Format(sqlb), conexion);
                retorno = _comando.ExecuteNonQuery();
                conexion.Close();
            }



            return retorno;


        }
    }

     
}
