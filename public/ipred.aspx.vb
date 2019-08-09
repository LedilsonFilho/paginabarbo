Imports System.Data
Imports System.Data.OleDb
Imports System.Web.Security
Imports System.Diagnostics
Imports System.ComponentModel


Partial Class escritorio_ipred
    Inherits System.Web.UI.Page

    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        Dim objConn As OleDbConnection
        Dim objCommand As OleDbCommand
        Dim codigo As String
        Dim ip As String
        Dim data As Date
        objConn = New OleDbConnection("Provider=Microsoft.Jet.OLEDB.4.0;Data Source=E:\home\barboengenharia\dados\escritorio.mdb;")
        objConn.Open()
        Dim strQuery As String = "SELECT codigo, ip, data FROM ipred WHERE codigo ='" + Request("codigo") + "'"
        objCommand = New OleDbCommand(strQuery, objConn)
        Dim objDataReader As OleDbDataReader
        objDataReader = objCommand.ExecuteReader(CommandBehavior.CloseConnection)
        While objDataReader.Read
            codigo = objDataReader.GetValue(0)
            ip = objDataReader.GetValue(1)
            data = objDataReader.GetValue(2)
        End While

        If codigo = "" Then
            Lb_msg.Text = "Código não encontrado"
        Else
            Lb_Ip.Text = "O IP do servidor é <ip>" + ip + "<ip>"
            Lb_Data.Text = "Atualizado em: " + data
            Lb_msg.Text = "Agora: " + Now
        End If



        If Request("tipo") = "add" Then
            Dim strQuery0 As String = "DELETE FROM ipred WHERE codigo = '" + codigo + "'"
            Dim objCommand0 As OleDbCommand = New OleDbCommand(strQuery0, objConn)
            Dim objDataReader0 As OleDbDataReader = objCommand0.ExecuteReader(CommandBehavior.CloseConnection)

            Dim strQuery1 As String = "INSERT INTO ipred (codigo, ip, data) VALUES ('" + Request("codigo") + "', '" + Request.UserHostAddress + "', '" + Now + "')"
            Dim objCommand1 As OleDbCommand = New OleDbCommand(strQuery1, objConn)
            Dim objDataReader1 As OleDbDataReader = objCommand1.ExecuteReader(CommandBehavior.CloseConnection)
            Lb_Ip.Text = Request.UserHostAddress
            Lb_Data.Text = Now
            Lb_msg.Text = "novo ip setado"
        End If

        objConn.Close()

    End Sub

End Class
