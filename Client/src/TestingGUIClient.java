
package com.codebind;
import com.UrlConnectionDK;

import javax.swing.*;
import javax.swing.filechooser.FileSystemView;
import javax.swing.text.BadLocationException;
import javax.swing.text.Document;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.beans.PropertyChangeEvent;
import java.beans.PropertyChangeListener;
import java.io.File;
import java.io.IOException;
import java.net.URLConnection;
import java.net.UnknownHostException;

public class TestingGUIClient {

    private static AccessoAccount acc;
    private static JFrame frame;
    private static String username;
    private static String password;
    private static JFrame frameApplicazione;
    private static Applicazione applicazione;
    private static String path;
    private static int iduser;
    private static boolean operazioneValida;
    private static String messageExe;

    public TestingGUIClient() throws IOException {
        acc = new AccessoAccount();
        frame = new JFrame("Demo Client Login");
        frameApplicazione = new JFrame("Demo Client");
        applicazione = new Applicazione();
    }


    public static void main(String[] args) throws IOException {
        // inizializzazione variabili
        new TestingGUIClient();
        //AccessoAccount acc = new AccessoAccount();
        frame.setSize(600, 500);
        frame.setResizable(false);
        frame.setContentPane(acc.PannelAccessoAccount);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);


        frameApplicazione.setResizable(true);
        frameApplicazione.setContentPane(applicazione.panelMain);
        frameApplicazione.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frameApplicazione.pack();
        frameApplicazione.setVisible(false);
    }

    public static void controlloCredenziali() throws IOException, BadLocationException {
        System.out.println("Controllo credenziali");
        frame.dispose();
        username = acc.getUsername();
        password = acc.getPassword();
        System.out.println("USERNAME: " + username);
        System.out.println("PASSWORD: " + password);
        UrlConnectionDK login = new UrlConnectionDK();
        login.setUsername(username);
        login.setPassword(password);
        login.checkLogin();
        String Status = login.getResponseCode();
        iduser = login.getIduser();

        System.out.println("Status: " + Status);
        System.out.println("IdUser: " + iduser);
        if (Status.equals("202")) {
            //ok connessione login fatta
            //imposto il path
            path = "/" + username;
            //chiamata frame APPLICAZIONE
            frameApplicazione.setVisible(true);
            showDir();
            visualizzazioneDir();
        } else {
            //errore
            acc.errorFrame(frame);
        }
    }

    public static void showDir(){
        JTextArea directoryShowing = applicazione.getShowDir();
        directoryShowing.setText("");
        directoryShowing.setText(path);
    }

    //visualizzazione dir
    public static void visualizzazioneDir() throws IOException, BadLocationException {
        VisualizeDK visualizza = new VisualizeDK();
        visualizza.setIduser(iduser);
        visualizza.setPath(path);
        visualizza.setPassword(password);
        visualizza.setUsername(username);
        //ottengo file e cartelle
        String currentFileFolder = visualizza.visualizzaDirectory();
        String visFileFolderAttuale[] = currentFileFolder.split("/");
        String[] positionFolder = path.split("/");
        int pos = positionFolder.length - 1;
        JTextPane contextDir = applicazione.getContextArea();
        contextDir.setText("");
        Document document = contextDir.getDocument();
        JLabel titledir = applicazione.getTitleApplication();
        titledir.setText("Welcome! " + username);
        JLabel labdir = applicazione.getCurrentDirWatching();
        labdir.setText("Contenuto della working directory: " + positionFolder[pos]);

        for (int i = 0; i < visFileFolderAttuale.length; i++) {
            // visualizzazione contenuto
            String testo = visFileFolderAttuale[i];
            String spazio = "    ";
            String identificaFile[] = testo.split(".");
            if (identificaFile.length > 1) {
                //file
                contextDir.getDocument().insertString(contextDir.getDocument().getLength(), testo, null);
                contextDir.getDocument().insertString(contextDir.getDocument().getLength(), spazio, null);
                //contextDir.insertComponent(labelFile);
            } else {
                //cartella
                contextDir.getDocument().insertString(contextDir.getDocument().getLength(), testo, null);
                contextDir.getDocument().insertString(contextDir.getDocument().getLength(), spazio, null);
                //contextDir.insertComponent(labelFolder);
            }
        }
    }

    public static void sendingOperation(String operazione, String value1, String value2) throws IOException, BadLocationException {

        JLabel labStatus = applicazione.getLabelStatusOperazione();
        JTextArea textStatus = applicazione.getStatusOperazione();
        JLabel inputlabel1 = applicazione.getLabelInput1();
        JFormattedTextField input2 = applicazione.getInput2();
        JFormattedTextField input1 = applicazione.getInput1();
        JButton sendingbutton = applicazione.getsendingOperation();

        operazioneValida = false;
        switch (operazione) {
            case "FW":
                String nameFolder = value1;
                operazioneValida = true;
                messageExe = "path=" + path + "&username=" + username + "&id=" + iduser + "&cartella=" + nameFolder + "&operazione=" + operazione + "&password=" + password;
                break;
            case "BK": //case Back
                messageExe = "path=" + path + "&username=" + username + "&id=" + iduser + "&operazione=" + operazione+"&password="+password;
                operazioneValida = true;
                break;
            case "HM": //case HOME
                path = "/"+username;
                operazioneValida = false;
                textStatus.setText("Ritornato nella Home");
                textStatus.setVisible(true);
                labStatus.setVisible(true);
                break;
            case "UF": //case UPLOAD
                JFileChooser jfc = new JFileChooser(FileSystemView.getFileSystemView().getHomeDirectory());
                int returnValue = jfc.showOpenDialog(null);
                if (returnValue == JFileChooser.APPROVE_OPTION) {
                    File selectedFile = jfc.getSelectedFile();
                    String pathFile = selectedFile.getAbsolutePath();
                    String filePath = pathFile;
                    File file = new File(filePath);
                    UploadFileConnectionDK upload = new UploadFileConnectionDK();
                    upload.setFile(file);
                    upload.setIduser(iduser);
                    upload.setPath(path);
                    upload.setPassword(password);
                    upload.setUsername(username);
                    upload.uploadFile();
                    String mex = upload.getMexRisposta();
                    textStatus.setText(mex);
                    textStatus.setVisible(true);
                    labStatus.setVisible(true);
                }else{//se fallisce
                    textStatus.setText("Status operazione: Operazione Upload File fallita, riprovare");
                    textStatus.setVisible(true);
                    labStatus.setVisible(true);
                }
                operazioneValida = false;
                break;
            case "DF":
                String nameFile = value1;
                //aggiornare a versione di oggi
                String saveDir="Download/";

                String postDataDW = "operazione="+operazione+
                        "&username="+username+
                        "&id="+iduser+
                        "&nameFile="+nameFile+
                        "&path="+path+
                        "&password="+password;

                DownloadFileconnectionDK download = new DownloadFileconnectionDK();
                download.setSaveDir(saveDir);
                download.setPostDataDW(postDataDW);
                download.setNameFile(nameFile);
                download.downloadFile();
                String mex =download.getMexExe();
                textStatus.setText(mex);
                textStatus.setVisible(true);
                labStatus.setVisible(true);
                operazioneValida=false;break;
            case "RF":   //case Remove File
                String nameFileToRemove = value1;
                messageExe ="path=" + path + "&username=" + username + "&id=" + iduser + "&nameFile=" + nameFileToRemove + "&operazione=" + operazione+"&password="+password;
                operazioneValida=true;break;
            case "MKDIR":  // case Creazione Folder
                nameFolder =value1;
                messageExe = "path=" + path + "&username=" + username + "&id=" + iduser + "&cartella=" + nameFolder + "&operazione=" + operazione+"&password="+password;
                operazioneValida = true;
                break;
            case "RMDIR": //case Remove Folder
                nameFolder = value1;
                messageExe = "path=" + path + "&username=" + username + "&id=" + iduser + "&cartella=" + nameFolder + "&operazione=" + operazione+"&password="+password;
                operazioneValida = true;
                break;
            case "MFDIR": //case Modify Folder
                String oldFolderName = value1;
                String newFolderName = value2;
                messageExe = "path=" + path + "&username=" + username + "&id=" + iduser + "&oldNameFolder=" + oldFolderName + "&newNameFolder=" + newFolderName + "&operazione=" + operazione+"&password="+password;
                operazioneValida = true;
                break;
        }//chiuso switch
        if (operazioneValida) {
            ExecutionConnectionDK execution = new ExecutionConnectionDK();
            execution.setMessageExe(messageExe);
            execution.setOperazione(operazione);
            execution.executionOperation();
            String handlingResponse = execution.getHandlingResponse();
            String responseResultExe;

            if (operazione.equals("BK") || operazione.equals("FW")) {
                String[] handlingPath = handlingResponse.split("-"); //MODIFICARE CON ? al posto di /
                responseResultExe = handlingPath[0];
                // assegnazione new path
                path = handlingPath[1];
                showDir();
            } else {
                // abbiamo solo un mex di avviso risultato operazione
                responseResultExe = handlingResponse;
            }
            visualizzazioneDir();
            textStatus.setText(responseResultExe);
            textStatus.setVisible(true);
            labStatus.setVisible(true);
            input1.setVisible(false);
            input2.setVisible(false);
            inputlabel1.setVisible(false);
            sendingbutton.setVisible(false);
        }else{
            //visualizzazione aggiornamento dir
            visualizzazioneDir();
            input1.setVisible(false);
            input2.setVisible(false);
            inputlabel1.setVisible(false);
            sendingbutton.setVisible(false);
        }
    }
}



