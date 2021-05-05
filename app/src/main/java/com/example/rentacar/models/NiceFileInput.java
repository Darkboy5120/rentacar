package com.example.rentacar.models;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.icu.text.SimpleDateFormat;
import android.net.Uri;
import android.os.Environment;
import android.provider.MediaStore;
import android.util.Base64;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.core.content.FileProvider;
import androidx.fragment.app.Fragment;

import com.example.rentacar.R;
import com.google.android.material.snackbar.Snackbar;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.util.Date;

public class NiceFileInput extends ControlField {
    private int status = 0;
    private static int ID_COUNTER = 0;
    private int REQUEST_IMAGE_CAPTURE;
    private String current_photo_path, file_name;
    private Bitmap file;
    private int status_id;

    public NiceFileInput(int label_id, int status_id, int input_id, int help_id, int log_id,
                         View view, Activity act, Fragment fragment) {
        this.REQUEST_IMAGE_CAPTURE = ID_COUNTER;
        this.ID_COUNTER++;
        this.label_id = label_id;
        this.status_id = status_id;
        this.input_id = input_id;
        this.help_id = help_id;
        this.log_id = log_id;
        ((Button) view.findViewById(this.input_id)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dispatchTakePictureIntent(act, view, fragment);
            }
        });
        ((TextView) view.findViewById(this.status_id)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (getStatus() == 1) {
                    showDialogImage(getFile(), view);
                }
            }
        });
        this.reset(view);
    }

    public void showDialogImage(Bitmap bitmap, View v) {
        AlertDialog.Builder alertadd = new AlertDialog.Builder(v.getContext());
        LayoutInflater factory = LayoutInflater.from(v.getContext());
        final View view = factory.inflate(R.layout.component_dialog_image, null);
        ImageView image = view.findViewById(R.id.dialog_image);
        image.setImageBitmap(bitmap);
        alertadd.setView(view);
        alertadd.setNeutralButton("Cerrar", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dlg, int sumthin) {
            }
        });
        alertadd.show();
    }

    public void listenResult(Activity activity, View root, int requestCode, int resultCode) {
        if (requestCode == this.REQUEST_IMAGE_CAPTURE && resultCode == activity.RESULT_OK) {
            try {
                BitmapFactory.Options options = new BitmapFactory.Options();
                options.inPreferredConfig = Bitmap.Config.ARGB_8888;
                this.file = BitmapFactory.decodeFile(this.getCurrentPhotoPath(), options);
                this.setStatus(1);
                this.dismissLog(root);
                this.setLogText(root, "1 elemento adjunto");
            } catch (Exception e) {
                e.printStackTrace();
                this.reset(root);
                this.printLog(root, root.getResources().getString(R.string.error_file_fetch));
            }
        }
    }

    public void reset(View v) {
        this.setLogText(v, "Vacío");
        this.setStatus(0);
    }

    public void setLogText(View v, String s) {
        ((TextView) v.findViewById(this.status_id)).setText(s);
    }

    public TextView getLog(View v) {
        return ((TextView) v.findViewById(this.status_id));
    }

    public int getStatus() {
        return this.status;
    }

    public void setStatus(int v) {
        this.status = v;
    }

    public void upload_file() {

    }

    public void changeLog() {
    }

    public void dispatchTakePictureIntent(Activity activity, View root, Fragment fragment) {
        Intent takePictureIntent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
        // Ensure that there's a camera activity to handle the intent
        if (takePictureIntent.resolveActivity(activity.getPackageManager()) != null) {
            // Create the File where the photo should go
            File photoFile = null;
            try {
                photoFile = createImageFile(activity);
            } catch (IOException ex) {
                // Error occurred while creating the File
                this.printLog(root, root.getResources().getString(R.string.error_file_fetch));
            }
            // Continue only if the File was successfully created
            if (photoFile != null) {
                Uri photoURI = FileProvider.getUriForFile(activity,
                        "com.rentacar.android.fileprovider",
                        photoFile);
                takePictureIntent.putExtra(MediaStore.EXTRA_OUTPUT, photoURI);
                fragment.startActivityForResult(takePictureIntent, REQUEST_IMAGE_CAPTURE);
            }
        }
    }

    private File createImageFile(Activity activity) throws IOException {
        // Create an image file name
        String timeStamp = new SimpleDateFormat("yyyyMMdd_HHmmss").format(new Date());
        String imageFileName = "JPEG_" + timeStamp + "_";
        this.file_name = imageFileName + this.getFileType();
        File storageDir = activity.getExternalFilesDir(Environment.DIRECTORY_PICTURES);
        File image = File.createTempFile(
                imageFileName,
                this.getFileType(),
                storageDir
        );

        // Save a file: path for use with ACTION_VIEW intents
        current_photo_path = image.getAbsolutePath();
        return image;
    }

    public String getCurrentPhotoPath() {
        return current_photo_path;
    }

    public Bitmap getFile() {
        return this.file;
    }

    public String getEncodedFile() {
        Bitmap bitmap = this.file;
        ByteArrayOutputStream byteArrayOutputStreamObject;
        byteArrayOutputStreamObject = new ByteArrayOutputStream();
        bitmap.compress(Bitmap.CompressFormat.JPEG, 100, byteArrayOutputStreamObject);
        byte[] byteArrayVar = byteArrayOutputStreamObject.toByteArray();
        return Base64.encodeToString(byteArrayVar, Base64.DEFAULT);
    }

    public String getFileName() {
        return file_name;
    }

    public boolean validate(View v) {
        if (this.status == 0) {
            this.printLog(v, v.getResources().getString(R.string.error_et_empty));
            return false;
        }
        return true;
    }

    public String getFileType() {
        return ".jpg";
    }
}
