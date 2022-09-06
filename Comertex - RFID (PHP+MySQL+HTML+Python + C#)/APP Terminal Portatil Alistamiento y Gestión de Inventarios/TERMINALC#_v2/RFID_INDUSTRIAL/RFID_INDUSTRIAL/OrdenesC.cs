using System;
using System.Linq;
using System.Collections.Generic;
using System.Text;
using System.Threading;
using MySql.Data.MySqlClient;

namespace RFID_INDUSTRIAL
{
    class OrdenesC
    {
        public static List<Ordenc> Buscar_despacho()
        {
            List<Ordenc> _lista = new List<Ordenc>();
            MySqlConnection conexion = Class1.ObtenerConexion();

            MySqlCommand _comando = new MySqlCommand(String.Format(
           "Select Id,noorden from com_ordencompra where estado_id=8"),conexion);
            MySqlDataReader _reader = _comando.ExecuteReader();
            while (_reader.Read())
            {
                Ordenc pOrdenes2 = new Ordenc();
                pOrdenes2.Id2 = _reader.GetInt32(0);
                pOrdenes2.norden = _reader.GetString(1);

                _lista.Add(pOrdenes2);
            }
            conexion.Close();
            return _lista;
        }


        /*public static Orden ObtenerOrden(int pId)
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

        }*/


        //Buscando los productos de un Pedido===============================================================================

        public static List<Ordenc2> ObtenerOrdenProducto(string Idp)
        {

            List<Ordenc2> _lista = new List<Ordenc2>();
            MySqlConnection conexion = Class1.ObtenerConexion();

            MySqlCommand _comando = new MySqlCommand(String.Format("SELECT com_inventario.Id,com_productos.codbarras,CONCAT(com_nombres.nombre,' ',	com_tipoproducto.nombre,' ',com_tallas.talla,' ',com_color.nombre) AS nombrep,	com_inventario.RFID,com_areas_almacenamiento.referencia,com_arraybodega.estante,com_arraybodega.nivel FROM com_inventario LEFT JOIN com_productos ON com_productos.Id = com_inventario.producto_id LEFT JOIN com_productosorden ON com_productosorden.Id = com_inventario.lineaoc_id LEFT JOIN com_lineaproducto ON com_lineaproducto.Id = com_productos.lineaproducto_id LEFT JOIN com_nombres ON com_nombres.Id = com_productos.nombre LEFT JOIN com_tipoproducto ON com_tipoproducto.Id = com_productos.tipoproducto_id LEFT JOIN com_tallas ON com_tallas.Id = com_productos.talla_id LEFT JOIN com_color ON com_color.Id = com_productos.color_id LEFT JOIN com_arraybodega ON com_arraybodega.Id=com_inventario.arraybodega_id LEFT JOIN com_areas_almacenamiento ON com_areas_almacenamiento.Id=com_arraybodega.areas_almacenamiento_id WHERE 	com_productosorden.orden_id = '{0}' AND com_inventario.estado = '2' GROUP BY	RFID ORDER BY producto_id ASC", Idp), conexion);

            MySqlDataReader _reader = _comando.ExecuteReader();
            while (_reader.Read())
            {
                Ordenc2 pOrdenes2 = new Ordenc2();
                pOrdenes2.Id2 = _reader.GetInt32(0);
                pOrdenes2.codbarras2 = _reader.GetString(1);
                //pOrdenes2.nombre = _reader.GetString(2);
                pOrdenes2.RFID2 = _reader.GetString(3);
                pOrdenes2.ubicacion2 = _reader.GetString(4) + "-" + _reader.GetString(5) + "-" + _reader.GetString(6);

                _lista.Add(pOrdenes2);
            }
            conexion.Close();
            return _lista;

        }

        //Guardando Ubicados en la Base de Datos==========================================================
        
        public static int GuardaOrden(string cadenaRFID,string pedidochange,string idpedido)
        {
            int retorno = 0;
            MySqlConnection conexion = Class1.ObtenerConexion();

            MySqlCommand _comando = new MySqlCommand(String.Format("UPDATE com_inventario SET estado='3' WHERE Id in ({0})", cadenaRFID), conexion);
            retorno = _comando.ExecuteNonQuery();

            if (pedidochange == "2")
            {
                MySqlCommand _comando2 = new MySqlCommand(String.Format("UPDATE com_ordencompra SET estado_id=9 WHERE Id={0}",idpedido), conexion);
                retorno = _comando2.ExecuteNonQuery();

                MySqlCommand _comando3 = new MySqlCommand(String.Format("UPDATE com_productosorden SET estado_id=9 WHERE orden_id={0}", idpedido), conexion);
                retorno = _comando3.ExecuteNonQuery();



            }
            
            conexion.Close();
            return retorno;

        }
    }

     
}
