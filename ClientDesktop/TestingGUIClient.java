
package com.codebind;
import com.UrlConnectionDK;

import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.beans.PropertyChangeEvent;
import java.beans.PropertyChangeListener;
import java.io.IOException;
import java.net.URLConnection;
import java.net.UnknownHostException;

public class TestingGUIClient{

    public static void main(String[] args) throws IOException {


        AccessoAccount acc = new AccessoAccount();
        JFrame frame = new JFrame("Demo Client");
        frame.setSize(500,500);
        frame.setResizable(false);
        frame.setContentPane(acc.PannelAccessoAccount);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setVisible(true);
    }


}
