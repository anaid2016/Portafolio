using System;
using System.Linq;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using NRfidApi;

namespace RFID_INDUSTRIAL
{
    public partial class Form1 : Form
    {
       
        public Form1()
        {
            InitializeComponent();
        }

        private void Form1_Closing(object sender, CancelEventArgs e)
        {
            /*if (rfid.IsOpen())
                rfid.Close();

            rfid.PowerOff();*/
        }


        private void button1_Click(object sender, EventArgs e)
        {
            Ordenes.conectar();
            MessageBox.Show("OK");
        }

        private void button2_Click(object sender, EventArgs e)
        {
            dataGrid1.DataSource = Ordenes.Buscar();
        }

        private void button5_Click(object sender, EventArgs e)
        {
            
            DataGridCell dc = dataGrid1.CurrentCell;
            int numberR = dc.ColumnNumber;
            String cellValue = dataGrid1[dc.RowNumber, dc.ColumnNumber].ToString();
            
            if (cellValue != null)
            {
                //MessageBox.Show("Numero" + numberR.ToString() + " y el valor " + cellValue);
                Form2 f12 = new Form2();
                f12.label2.Text = cellValue;
                f12.setvar(cellValue);
                this.Hide();
                f12.Show();
            }
            else
            {
                MessageBox.Show("No hay Ordenes Pendientes");
            }

           
        }

        private void button3_Click(object sender, EventArgs e)
        {
            dataGrid2.DataSource = OrdenesC.Buscar_despacho();
        }

        private void button6_Click(object sender, EventArgs e)
        {
            DataGridCell dc2 = dataGrid2.CurrentCell;
            int numberR2 = dc2.ColumnNumber;
            if (numberR2 == 0)
            {

                String cellValue2 = dataGrid2[dc2.RowNumber, dc2.ColumnNumber].ToString();

                if (cellValue2 != null)
                {
                    //MessageBox.Show("Numero" + numberR2.ToString() + " y el valor " + cellValue);
                    Form3 f13 = new Form3();
                    f13.setvar2(cellValue2);
                    this.Hide();
                    f13.Show();
                }
                else
                {
                    MessageBox.Show("No hay Ordenes Pendientes");
                }

            }
        }

        private void button4_Click(object sender, EventArgs e)
        {
            Application.Exit();
           /* if (rfid.IsOpen())
                rfid.Close();

            rfid.PowerOff();*/
        }



        //FIN PROGRAMA
    }
}