﻿using System;
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

namespace RFID_INDUSTRIAL
{
    public partial class Form2 : Form
    {

        ArrayList Tags = new ArrayList();
        RfidApi rfid;
        int entra = 1;
        string cadenasql = "";
        int filas = 0;
        string idpedidob = "";

        public Form2()
        {
            InitializeComponent();

            //Para lectura del RFID ===========================================================
            this.Text = "SelectTest";

            //Conexion a la Base de Datos=========================================================================================
            //Class1.ObtenerConexion();
            //label3.Text = "Conectado a BD";


            Cursor.Current = Cursors.WaitCursor;
            rfid = new RfidApi();
            rfid.PowerOn();
            if (rfid.Open() != RFID_RESULT.RFID_RESULT_SUCCESS)
            {
                MessageBox.Show("rfid Open failed");
                rfid.PowerOff();
                Application.Exit();
            }
            rfid.SetCallback(new RfidCallbackProc(CallbackProc));
            rfid.PowerLevel = 15;
            Cursor.Current = Cursors.Default;
        }

        public void setvar(string v)
        {
            //Buscando los RFID pertenecientes al pedido
            idpedidob = v;
            dataGrid1.DataSource = Ordenes.ObtenerPedidoProducto(idpedidob);
        }

        //Librerias para el RFID =======================================================================

        private void Form2_Closing(object sender, CancelEventArgs e)
        {
            if (rfid.IsOpen())
                rfid.Close();

            rfid.PowerOff();
        }


        private void button1_Click(object sender, EventArgs e)
        {
            label3.Text = "Buscando RFID...";
            RFID_RESULT result = rfid.ReadEpc(false, RFID_READ_TYPE.EPC_GEN2_MULTI_TAG, null);

            //System.Diagnostics.Debug.WriteLine("ReadEpc : " + result.ToString());
        }


        //Funcion para guardar los resultados encontrados====================================================
        private void button2_Click(object sender, EventArgs e)
        {
            rfid.Stop();
            label3.Text = "Guardando...";
            //Cadena para Guardar en SQL=========================================================
            int total = cadenasql.Length;
            string salida = cadenasql.Substring(1, total - 1);
            string pedidochange = "1";   // No guarda el estado del pedido
            if (filas == (entra - 1))
            {
                pedidochange = "2";
            }

            int rstsql = Ordenes.GuardaPedido(salida, pedidochange, idpedidob);
            if (rstsql == 1)
            {
                label3.Text = "Guardado OK";
            }
            else
            {
                label3.Text = "Error";
            }
        }

        //Funcion que obtiene el RFID y lo compara con el datagrid=================================

        public void CallbackProc(RFIDCALLBACKDATA CallbackData)
        {
            string Msg = new string(new char[512]);
            rfid.GetResult(Msg, CallbackData.CallbackType, CallbackData.wParam, CallbackData.lParam);
            Msg = Msg.Substring(1, Msg.IndexOf("\0"));

            if (CallbackData.CallbackType == RFID_CALLBACK_TYPE.RFIDCALLBACKTYPE_DATA)
            {

                string hexString = Msg.Trim();
                int iRow = 0;


                //1. Pasar RFID de HEXADECIMAL a DECIMAL=================================
                int num = Int32.Parse(hexString, System.Globalization.NumberStyles.HexNumber);
                //int num = Convert.ToInt32(hexString);       //Solo mientras se prueba con los marcados por la estanteria, esto debe ser hexa no decimal

                //2. Sacar listado del Datagrid ==========================================
                filas = dataGrid1.VisibleRowCount;
                int cols = dataGrid1.VisibleColumnCount;

                for (iRow = 0; iRow < filas; iRow++)
                {
                    string rfidnow = dataGrid1[iRow, 2].ToString();
                    string num2 = num.ToString();
                    //MessageBox.Show("y aqui llega" + num2 + rfidnow);

                    if (num2 == rfidnow && dataGrid1.IsSelected(iRow) == false)
                    {
                        //3. Marcar como encontrado en Datagrid=====================================
                        cadenasql = cadenasql + ",'" + dataGrid1[iRow, 0].ToString() + "'";

                        //4. Guardar Resultados ============================================================
                        dataGrid1.Select(iRow);
                        entra = entra + 1;

                    }


                }

            }
        }

        private void button3_Click(object sender, EventArgs e)
        {
            if (rfid.IsOpen())
                rfid.Close();

            rfid.PowerOff();

            Form1 f11 = new Form1();
            this.Hide();
            f11.Show();

            //Application.Exit();
        }
        //======================================================

    }
}