VERSION 5.00
Object = "{EAB22AC0-30C1-11CF-A7EB-0000C05BAE0B}#1.1#0"; "shdocvw.dll"
Begin VB.Form frmMain 
   Caption         =   "WinTrigger for/für mysqldumper"
   ClientHeight    =   8955
   ClientLeft      =   60
   ClientTop       =   450
   ClientWidth     =   11400
   LinkTopic       =   "Form1"
   ScaleHeight     =   8955
   ScaleWidth      =   11400
   StartUpPosition =   3  'Windows-Standard
   Begin VB.TextBox txtPass 
      Height          =   285
      Left            =   3840
      TabIndex        =   8
      Text            =   "Text2"
      Top             =   240
      Width           =   2415
   End
   Begin VB.TextBox txtUser 
      Height          =   285
      Left            =   720
      TabIndex        =   6
      Text            =   "Text1"
      Top             =   240
      Width           =   2295
   End
   Begin VB.CheckBox chkLog 
      Caption         =   "Save Result / Ergebnis Speichern"
      Height          =   375
      Left            =   6480
      TabIndex        =   5
      Top             =   120
      Width           =   1815
   End
   Begin VB.CheckBox chkExit 
      Caption         =   "Exit after Backup / Nach Backup beenden"
      Height          =   375
      Left            =   8760
      TabIndex        =   4
      Top             =   120
      Width           =   2055
   End
   Begin VB.CommandButton cmdGet 
      Caption         =   "Go / Los"
      Height          =   375
      Left            =   9360
      TabIndex        =   2
      Top             =   600
      Width           =   1335
   End
   Begin VB.TextBox txtURL 
      Height          =   375
      Left            =   720
      TabIndex        =   1
      Top             =   600
      Width           =   8295
   End
   Begin SHDocVwCtl.WebBrowser webDump 
      Height          =   7095
      Left            =   240
      TabIndex        =   0
      Top             =   1320
      Width           =   10935
      ExtentX         =   19288
      ExtentY         =   12515
      ViewMode        =   0
      Offline         =   0
      Silent          =   0
      RegisterAsBrowser=   0
      RegisterAsDropTarget=   1
      AutoArrange     =   0   'False
      NoClientEdge    =   0   'False
      AlignLeft       =   0   'False
      NoWebView       =   0   'False
      HideFileNames   =   0   'False
      SingleClick     =   0   'False
      SingleSelection =   0   'False
      NoFolders       =   0   'False
      Transparent     =   0   'False
      ViewID          =   "{0057D0E0-3573-11CF-AE69-08002B2E1262}"
      Location        =   "http:///"
   End
   Begin VB.Label Label3 
      Caption         =   "Copyright Crazy Morty - morty@gmx.de"
      Height          =   255
      Left            =   8280
      TabIndex        =   10
      Top             =   8640
      Width           =   2775
   End
   Begin VB.Label Label2 
      Caption         =   "Pass:"
      Height          =   255
      Left            =   3360
      TabIndex        =   9
      Top             =   240
      Width           =   735
   End
   Begin VB.Label lbl1 
      Caption         =   "User:"
      Height          =   255
      Left            =   240
      TabIndex        =   7
      Top             =   240
      Width           =   615
   End
   Begin VB.Label Label1 
      Caption         =   "Url:"
      Height          =   255
      Left            =   240
      TabIndex        =   3
      Top             =   720
      Width           =   495
   End
End
Attribute VB_Name = "frmMain"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Option Explicit
Dim Loading As Boolean

Private Sub cmdGet_Click()
    Loading = True
    If Left(txtURL, 7) = "http://" Then
        txtURL = Mid(txtURL, 8)
    End If
    webDump.Navigate2 "http://" & txtUser & ":" & txtPass & "@" & txtURL.Text
End Sub

Private Sub Form_Load()
    Dim para As Variant
    For Each para In Split(Command)
        If LCase(para) = "/log" Then
            chkLog = 1
        ElseIf LCase(para) = "/exit" Then
            chkExit = 1
        ElseIf LCase(para) = "/hide" Then
            Me.Hide
        ElseIf Left(LCase(para), 5) = "/url:" Then
            txtURL = Mid(para, 6)
        ElseIf Left(LCase(para), 6) = "/user:" Then
            txtUser = Mid(para, 7)
        ElseIf Left(LCase(para), 6) = "/pass:" Then
            txtPass = Mid(para, 7)
        End If
    Next para
    If txtURL = "" Then
        Me.Show ' Falls /hide gesetz wurde
    Else
        cmdGet_Click
    End If
End Sub

Private Sub webDump_DownloadComplete()
    'DoEvents
    If Not Loading Then Exit Sub
    On Error GoTo Ausgang ' Etwas blöder Workaround
    If InStr(webDump.Document.body.outerhtml, "document.dump.submit()") Then Exit Sub
    On Error GoTo 0
    Loading = False
    If chkLog.Value = 1 Then
        Open "MySqlDumper_" & Format(Now, "yyyy_mm_Dd_hh_nn_ss") & ".htm" For Output As #1
            Print #1, webDump.Document.body.outerhtml
        Close #1
    End If
    If chkExit.Value = 1 Then
        DoEvents
        Unload Me
        Exit Sub
    End If
    Exit Sub
Ausgang:
End Sub

