package com.codebind;

import javax.swing.*;
import java.awt.*;


public class App {
    public JPanel panelMain;
    private JRadioButton radioButton1;
    private JRadioButton radioButton2;
    private JRadioButton radioButton3;
    private JRadioButton radioButton4;
    private JRadioButton radioButton5;
    private JRadioButton radioButton6;
    private JButton Submit_Operation;
    private JButton Undo_Operation;
    private JButton Home;
    private JButton Back;
    private JTextField ShowDir;
    private JTextArea textArea1;

    public App() {
        //gestione ShowDir
        ShowDir.setText("/LucaDanie/MainCartella");
        ShowDir.setEditable(false);
    }


}
