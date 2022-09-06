using System;
using System.Linq;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.Runtime.InteropServices;
using System.Collections;
using NRfidApi;
using MySql.Data.MySqlClient;


namespace RFID_INDUSTRIAL
{
    public partial class Form4 : Form
    {
        //Declaraciones
        ArrayList Tags = new ArrayList();
        RfidApi rfid;
        DataTable dt2 = new DataTable();
        int filas = 0;
        string oldvcombo = "";
                
        
        public Form4()
        {
            InitializeComponent();

            //Para iniciar RFID
            Cursor.Current = Cursors.WaitCursor;
            rfid = new RfidApi();
            rfid.PowerOn();
            if (rfid.Open() != RFID_RESULT.RFID_RESULT_SUCCESS)
            {
                MessageBox.Show("rfid Open failed");
                rfid.Stop();
                rfid.PowerOff();
                Application.Exit();
            }
            rfid.SetCallback(new RfidCallbackProc(CallbackProc));
            rfid.PowerLevel = 8;
            Cursor.Current = Cursors.Default;

        }

        public class Product
        {
            public int Estante { get; set; }
            public string RFID { get; set; }
        }


        private void Form4_Load(object sender, EventArgs e)
        {
            MySqlConnection conexion = Class1.ObtenerConexion();
            MySqlCommand _comando = new MySqlCommand(String.Format("Select com_arraybodega.Id,CONCAT(com_areas_almacenamiento.referencia,'-',estante,'-',nivel) as cajonera from com_arraybodega LEFT JOIN com_areas_almacenamiento ON com_areas_almacenamiento.Id=com_arraybodega.areas_almacenamiento_id ORDER BY estante,nivel"), conexion);
            MySqlDataAdapter da1 = new MySqlDataAdapter(_comando);
	        DataTable dt = new DataTable();
	        da1.Fill(dt);


            comboBox1.ValueMember = "id";
            comboBox1.DisplayMember = "cajonera";
            comboBox1.DataSource = dt;

            conexion.Close();

            //Para el Datagri=========================================

            dt2.Columns.Add("RFID", typeof(string));
        }

        private void button1_Click(object sender, EventArgs e)
        {
            label1.Text = "Leyendo RFID";
            RFID_RESULT result = rfid.ReadEpc(false, RFID_READ_TYPE.EPC_GEN2_MULTI_TAG, null);
        }


        private void Form4_Closing(object sender, CancelEventArgs e)
        {
            rfid.Stop();

            if (rfid.IsOpen())
                rfid.Close();

            rfid.PowerOff();
        }

        //Funcion que obtiene el RFID y lo anexa al datagrid=================================

        public void CallbackProc(RFIDCALLBACKDATA CallbackData)
        {
            string Msg = new string(new char[512]);
            rfid.GetResult(Msg, CallbackData.CallbackType, CallbackData.wParam, CallbackData.lParam);
            Msg = Msg.Substring(1, Msg.IndexOf("\0"));

            if (CallbackData.CallbackType == RFID_CALLBACK_TYPE.RFIDCALLBACKTYPE_DATA)
            {

                string hexString = Msg.Trim();

                //1. Pasar RFID de HEXADECIMAL a DECIMAL=================================
                int num = Int32.Parse(hexString, System.Globalization.NumberStyles.HexNumber);
                //int num = Convert.ToInt32(hexString);       //Solo mientras se prueba con los marcados por la estanteria, esto debe ser hexa no decimal
                string num2 = num.ToString();       //Convirtiendo en string======================================
                string vcombo = comboBox1.Text;
                string flag1 = "1";

                //MessageBox.Show(oldvcombo + "--" + vcombo);

                if (vcombo != oldvcombo)
                {
                    dt2.Clear();
                }

                //Agregando al datagrid========================================================
               

                foreach (DataRow row in dt2.Rows)
                {
                    if (row["RFID"].ToString() == num2)
                    {
                        flag1 = "2";
                    }
                    
                }

                if (flag1 == "1")
                {
                    DataRow DR = dt2.NewRow();
                    DR["RFID"] = num2;
                    dt2.Rows.Add(DR);
                    dataGrid1.DataSource = dt2;
                }
                oldvcombo = vcombo;

            }
        }

        private void button3_Click(object sender, EventArgs e)
        {
            label1.Text = "Cerrando..";
            rfid.Stop();
            if (rfid.IsOpen())
                rfid.Close();

            rfid.PowerOff();

            Form1 f11 = new Form1();
            this.Hide();
            f11.Show();
        }

        private void button4_Click(object sender, EventArgs e)
        {
            filas = dataGrid1.VisibleRowCount;
            int cols = dataGrid1.VisibleColumnCount;
            string cadenasql = "";
            int iRow = 0;

            for (iRow = 0; iRow < filas; iRow++)
            {
                
               //1- Asignando Cadena para Guardar en Base de Datos
               cadenasql = cadenasql + ",'" + dataGrid1[iRow, 0].ToString() + "'";
            }

            rfid.Stop();
            label1.Text = "Guardando...";

            if (cadenasql != "")
            {
                int total = cadenasql.Length;
                string salida = cadenasql.Substring(1, total - 1);
                string estante = comboBox1.SelectedValue.ToString();

               
                int rstsql = Ordenes.GuardarInventario(salida, estante);

                if (rstsql >= 0)
                {
                    label1.Text = "Guardado con Exito";
                }


            }
        }

        private void button2_Click(object sender, EventArgs e)
        {
            rfid.Stop();
            label1.Text = "RFID DETENIDO";
        }


    }
}