package com.codebind;

import java.awt.*;
import java.beans.PropertyChangeSupport;
import java.io.IOException;
import javax.swing.*;
import java.awt.event.*;
import java.net.URI;

public class AccessoAccount {
    public JPanel PannelAccessoAccount;
    private PropertyChangeSupport pcs = new PropertyChangeSupport(this);
    private JTextArea textAreaDomanda1;
    private JLabel LabelTitle;
    private JFormattedTextField usernameInput;
    private JLabel ImageWelcome;
    private JPasswordField passwordInput;
    private JLabel NoAccountLabel;
    private JLabel RegistratiAccount;
    private JButton StartLogin;

    //variabili globali
    public String username;
    public String password;

    public AccessoAccount() throws IOException{
        //fonts
        Font fontText = new Font("SansSerif", Font.BOLD, 20);
        Font fontLabel = new Font("Arial", Font.BOLD, 16);
        Font bold = new Font("Arial", Font.BOLD, 15);

        //LABEL
        NoAccountLabel.setFont(bold);
        LabelTitle.setFont(fontLabel);
        //CAMPO TEXT
        textAreaDomanda1.setFont(fontText);
        textAreaDomanda1.setEditable(false);

        // LINK REGISTRATI ACCOUNT
        RegistratiAccount.setCursor(Cursor.getPredefinedCursor(Cursor.HAND_CURSOR));
        RegistratiAccount.setForeground(Color.BLUE.darker());
        RegistratiAccount.addMouseListener(new MouseAdapter() {
            @Override
            public void mouseClicked(MouseEvent e) {
                if (e.getClickCount() > 0) {
                    try {
                        Desktop.getDesktop().browse(new URI("http://serverwebuni.ns0.it:580/register.html"));
                    } catch (Exception ex) {
                        ex.printStackTrace();
                    }
                }
            }
        });
        //bottone


        //campi inserimento FOCUS listener
        usernameInput.addFocusListener(new FocusListener() {
            public void focusGained(FocusEvent e) {
                // Utente entrato nella casella di testo
        }
            public void focusLost(FocusEvent e) {
                // Utente si sposta
                username = usernameInput.getText();
            }
        });

        passwordInput.addFocusListener(new FocusListener() {
            public void focusGained(FocusEvent e) {
                // Il focus è stato guadagnato
            }
            public void focusLost(FocusEvent e) {
                // Il focus è stato perso
                char[] passwordChar = passwordInput.getPassword();
                password = new String(passwordChar);
            }
        });

    }

    public JButton getStartLogin() {
        return StartLogin;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String u){
        this.username=u;
    }

    public String getPassword() {
        return password;
    }

    public JPanel getPannelAccessoAccount() {
        return PannelAccessoAccount;
    }


}
