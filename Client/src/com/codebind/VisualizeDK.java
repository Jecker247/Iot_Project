package com.codebind;
import javax.swing.*;
import javax.swing.filechooser.FileSystemView;
import java.io.*;
import java.net.*;
import java.util.Scanner;
import java.lang.Integer;
import java.awt.Desktop;
import java.io.IOException;

public class VisualizeDK {
    public String username;
    public String password;
    public String path;
    public int iduser;

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getPath() {
        return path;
    }

    public void setPath(String path) {
        this.path = path;
    }

    public int getIduser() {
        return iduser;
    }

    public void setIduser(int iduser) {
        this.iduser = iduser;
    }

    public String visualizzaDirectory()throws IOException{
        URL urlVis = new URL("http", "serverwebuni.ns0.it", 580, "/php/visualizzazione.php");
        HttpURLConnection conVis = (HttpURLConnection) urlVis.openConnection();
        conVis.setRequestMethod("POST");
        conVis.setDoOutput(true);
        String messageVis = "username=" + username + "&id=" + iduser + "&path=" + path + "&password=" + password;
        OutputStream osVis = conVis.getOutputStream();
        osVis.write(messageVis.getBytes());
        osVis.flush();
        osVis.close();
        BufferedReader inVis = new BufferedReader(new InputStreamReader(conVis.getInputStream()));
        String inputLineVis;
        StringBuffer responseVis = new StringBuffer();
        while ((inputLineVis = inVis.readLine()) != null) {
            responseVis.append(inputLineVis);  // mex risposta dal server dell'operazione eseguita
        }
        inVis.close();
        String feedback = responseVis.toString();
        return feedback;
    }
}
