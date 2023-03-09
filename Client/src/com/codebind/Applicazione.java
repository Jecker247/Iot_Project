package com.codebind;

import javax.swing.*;
import javax.swing.text.BadLocationException;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.FocusEvent;
import java.awt.event.FocusListener;
import java.io.IOException;

public class Applicazione {
    public JPanel panelMain;
    private JLabel TitleApplication;
    private JTextPane contextArea;
    private JLabel CurrentDirWatching;
    private JButton removeFile;
    private JButton UploadFile;
    private JLabel operazioneLabel;
    private JButton DownloadFile;
    private JButton RemoveFolder;
    private JButton InsertFolder;
    private JButton ModifyFolder;
    private JLabel OperationPosition;
    private JButton backwardButton;
    private JButton Home;
    private JButton ForwardButton;
    private JFormattedTextField Input1;
    private JLabel LabelInput1;
    private JButton sendingOperation;
    private JTextArea StatusOperazione;
    private JLabel LabelStatusOperazione;
    private JTextArea ShowDir;
    private JFormattedTextField Input2;
    private JButton currentDirButton;


    public String operazione;
    public String valueInput1;
    public String valueInput2;

    public Applicazione(){

        Font fontText = new Font("SansSerif", Font.BOLD, 20);
        TitleApplication.setFont(fontText);
        Input1.setVisible(false);
        LabelInput1.setVisible(false);
        sendingOperation.setVisible(false);
        Input2.setVisible(false);
        LabelStatusOperazione.setVisible(false);
        StatusOperazione.setVisible(false);
        StatusOperazione.setEditable(false);
        ShowDir.setEditable(false);
        contextArea.setEditable(false);
        //gestione action listener DIRECTORY

        //FW BUTTON
        ForwardButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                Input1.setVisible(true);
                operazione = "FW";
                valueInput2=null;
                Input1.setText("");
                LabelInput1.setText("Inserisci il nome della cartella:" );
                LabelInput1.setVisible(true);
                sendingOperation.setVisible(true);
            }
        });

        // BK BUTTON
        backwardButton.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent e) {
                operazione = "BK";
                valueInput2=null;
                valueInput1=null;
                sending(operazione,valueInput1,valueInput2);
            }
        });

        //HM BUTTON
        Home.addActionListener(new ActionListener(){
            public void actionPerformed(ActionEvent e){
                operazione = "HM";
                valueInput2=null;
                valueInput1=null;
                sending(operazione,valueInput1,valueInput2);
            }
        });

        //BUTTON UPLOAD
        UploadFile.addActionListener(new ActionListener(){
            public void actionPerformed(ActionEvent e) {
                operazione = "UF";
                valueInput2 = null;
                valueInput1 = null;
                sending(operazione,valueInput1,valueInput2);
            }
        });

        //download
        DownloadFile.addActionListener(new ActionListener(){
            @Override
            public void actionPerformed(ActionEvent e) {
                Input1.setVisible(true);
                Input1.setText("");
                LabelInput1.setText("Inserisci il nome del file da scaricare:" );
                LabelInput1.setVisible(true);
                sendingOperation.setVisible(true);
                operazione = "DF";
                valueInput2 = null;
                valueInput1 = null;
            }
        });

        //remove file
        removeFile.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                Input1.setVisible(true);
                Input1.setText("");
                LabelInput1.setText("Inserisci il nome del file da rimuovere:" );
                LabelInput1.setVisible(true);
                sendingOperation.setVisible(true);
                operazione = "RF";
                valueInput2 = null;
                valueInput1= null;
            }
        });

        //insert folder
        InsertFolder.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                Input1.setVisible(true);
                Input1.setText("");
                LabelInput1.setText("Inserisci il nome del folder:" );
                LabelInput1.setVisible(true);
                sendingOperation.setVisible(true);
                operazione = "MKDIR";
                valueInput2 = null;
                valueInput1= null;
            }
        });

        //remove folder
        RemoveFolder.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                Input1.setVisible(true);
                Input1.setText("");
                LabelInput1.setText("Inserisci il nome del folder:" );
                LabelInput1.setVisible(true);
                sendingOperation.setVisible(true);
                operazione = "RMDIR";
                valueInput2 = null;
                valueInput1= null;
            }
        });

        //modify folder
        ModifyFolder.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                Input1.setVisible(true);
                Input1.setText("");
                Input2.setVisible(true);
                Input2.setText("");
                LabelInput1.setText("Inserisci il nome del folder:" );
                LabelInput1.setVisible(true);
                sendingOperation.setVisible(true);
                operazione = "MFDIR";
            }
        });


                //campi inserimento FOCUS listener
                Input1.addFocusListener(new FocusListener() {
                    public void focusGained(FocusEvent e) {
                        // Utente entrato nella casella di testo
                    }

                    public void focusLost(FocusEvent e) {
                        // Utente si sposta
                        valueInput1 = Input1.getText();
                    }
                });

        Input2.addFocusListener(new FocusListener() {
            public void focusGained(FocusEvent e) {
                // Utente entrato nella casella di testo
            }

            public void focusLost(FocusEvent e) {
                // Utente si sposta
                valueInput2 = Input2.getText();
            }
        });


        //rilevamento bottone INVIO
        sendingOperation.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                sending(operazione,valueInput1,valueInput2);
            }
        });



    }

    public void sending(String operazione, String valueInput1,String valueInput2){
        try {
            com.codebind.TestingGUIClient.sendingOperation(operazione,valueInput1,valueInput2);
        } catch (IOException ex) {
            ex.printStackTrace();
        } catch (BadLocationException ex) {
            ex.printStackTrace();
        }
    }

    public JFormattedTextField getInput1(){
        return Input1;
    }
    public JLabel getLabelInput1(){
        return LabelInput1;
    }
    public JButton getsendingOperation(){
        return sendingOperation;
    }

    public JLabel getLabelStatusOperazione(){
        return LabelStatusOperazione;
    }

    public JTextArea getStatusOperazione(){
        return StatusOperazione;
    }

    public JTextPane getContextArea(){
        return contextArea;
    }

    public JLabel getCurrentDirWatching(){
        return CurrentDirWatching;
    }

    public JLabel getTitleApplication(){
        return TitleApplication;
    }
    public JTextArea getShowDir(){
        return ShowDir;
    }
    public JFormattedTextField getInput2(){
        return Input2;
    }
}
