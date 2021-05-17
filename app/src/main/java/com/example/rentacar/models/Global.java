package com.example.rentacar.models;

import android.app.Activity;
import android.content.Context;
import android.text.TextUtils;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.TextView;

import androidx.fragment.app.FragmentManager;

import com.google.android.material.snackbar.Snackbar;

import java.util.ArrayList;

public class Global {
    public final static String domain_name = "https://chilaquilesenterprise.com/rentacar/";
    public final static String apis_path = domain_name + "model/apis/";
    public final static String generic_error = "That didn't work!";
    public final static String security_key = "$2y$10$09JtLoAwMSUYwDzag87.yu8BuFUVwLG44oVWPmnMnKiFDtNUE9vWi";

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

    public static ArrayList<View> getAllChildren(View v) {

        if (!(v instanceof ViewGroup)) {
            ArrayList<View> viewArrayList = new ArrayList<View>();
            viewArrayList.add(v);
            return viewArrayList;
        }

        ArrayList<View> result = new ArrayList<View>();

        ViewGroup vg = (ViewGroup) v;
        for (int i = 0; i < vg.getChildCount(); i++) {

            View child = vg.getChildAt(i);

            ArrayList<View> viewArrayList = new ArrayList<View>();
            viewArrayList.add(v);
            viewArrayList.addAll(getAllChildren(child));

            result.addAll(viewArrayList);
        }
        return result;
    }

    public static TextView searchViewByText(ArrayList<View> allViewsWithinMyTopView, String toSearchFor) {
        TextView targetView = null;
        for (View child : allViewsWithinMyTopView) {
            if (child instanceof TextView) {
                TextView childTextView = (TextView) child;
                if (TextUtils.equals(childTextView.getText().toString(), toSearchFor)) {
                    targetView = childTextView;
                }
            }
        }
        return targetView;
    }
}
