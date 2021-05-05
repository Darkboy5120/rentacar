package com.example.rentacar.models;

import android.app.Activity;
import android.content.Context;
import android.view.View;
import android.view.inputmethod.InputMethodManager;

import androidx.fragment.app.FragmentManager;

import com.google.android.material.snackbar.Snackbar;

public class Global {
    public static String domain_name = "https://chilaquilesenterprise.com/rentacar/";
    public static String apis_path = domain_name + "model/apis/";
    public static String generic_error = "That didn't work!";

    public static void clearBackStack(FragmentManager fm) {
        fm.popBackStack(null, FragmentManager.POP_BACK_STACK_INCLUSIVE);
    }

    public static void printMessage(View v, String s) {
        Snackbar.make(v, s, Snackbar.LENGTH_LONG)
                /*.setAction("Action", null)*/.show();
    }

    public static void hideKeyboardFrom(Context context, View view) {
        InputMethodManager imm = (InputMethodManager) context.getSystemService(Activity.INPUT_METHOD_SERVICE);
        imm.hideSoftInputFromWindow(view.getWindowToken(), 0);
        view.clearFocus();
    }

    public static String buildUrl(String url, String... param) {
        String key = "?";
        for(int i = 0; i < (param.length / 2); i++) {
            url = url + key + param[(i*2)] + "=" + param[(i*2+1)];
            if (i == 0) key = "&";
        }
        return url;
    }
}
