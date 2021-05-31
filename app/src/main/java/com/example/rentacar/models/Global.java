package com.example.rentacar.models;

import android.app.Activity;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.text.TextUtils;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.fragment.app.FragmentManager;

import com.google.android.material.snackbar.Snackbar;

import java.io.IOException;
import java.io.InputStream;
import java.net.URL;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.Locale;

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

    public static Bitmap getBitmapFromUrl(String imageUrl) {
        try {
            return BitmapFactory.decodeStream((InputStream) new URL(imageUrl).getContent());
        } catch (IOException e) {
            e.printStackTrace();
        }
        return null;
    }

    public static void setImage(String url, ImageView view) {
        new Thread(() -> {
            final Bitmap bitmap =
                    getBitmapFromUrl(url);
            view.post(() -> view.setImageBitmap(bitmap));
        }).start();
    }

    public static long get_milli_from_date(String date) {
        SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy", Locale.US);
        try {
            Date mDate = sdf.parse(date);
            long timeInMilliseconds = mDate.getTime();
            return timeInMilliseconds;
        }
        catch (ParseException e) {
            e.printStackTrace();
        }
        return 0;
    }

    public static long get_milli_from_time(String time) {
        SimpleDateFormat sdf = new SimpleDateFormat("hh:mm", Locale.US);
        try {
            Date mDate = sdf.parse(time);
            long timeInMilliseconds = mDate.getTime();
            return timeInMilliseconds;
        }
        catch (ParseException e) {
            e.printStackTrace();
        }
        return 0;
    }

    public static long get_milli_from_current_datetime() {
        Calendar rightNow = Calendar.getInstance();
        return rightNow.getTimeInMillis();
    }
}
