using System;
using System.Linq;
using System.Collections.Generic;
using System.Text;
using MySql.Data.MySqlClient;

namespace RFID_INDUSTRIAL
{
    public class Class1
    {
        public static MySqlConnection ObtenerConexion()
        {
            MySqlConnection conectar = new MySqlConnection("server=192.168.0.8; database=bodega; Uid=root; pwd=123456;");

            conectar.Open();
            return conectar;
        }
    }
}
