package apps.lutfi.aplikasikesehatanibudananak;

import android.annotation.SuppressLint;
import android.app.DatePickerDialog;
import android.app.ProgressDialog;
import android.app.TimePickerDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Spinner;
import android.widget.TimePicker;
import android.widget.Toast;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.lang.reflect.Constructor;
import java.lang.reflect.Method;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;
import java.util.Locale;

public class KetLahir extends AppCompatActivity {
    private EditText txtNoKetLhr, txtTglLhr, txtJamLhr, txtKelahiranKe, txtBerat, txtPanjangBadan,
            txtNamaTempatPersalinan, txtAlamatTempatPersalinan, txtNamaAnak, txtSaksi1, txtSaksi2,
            txtNamaIbu, txtUmurIbu, txtPekerjaanIbu, txtNIKIbu, txtNamaAyah, txtUmurAyah,
            txtNIKAyah, txtAlamat, txtKec, txtKab;
    private Spinner cmbJK, cmbJnsKelahiran, cmbLahirDi, cmbPenolongPersalinan;
    private List<String> spinnerArray = null;
    private ArrayAdapter<String> adapter = null, adapterJK, adapterJnsKelahiran, adapterLahirDi, adapterPenolongPersalinan;
    private ProgressDialog progressDialog;
    private JSONObject hasilJsonObject = null;
    private JSONArray jsonArray;
    private Calendar myCalendar;
    private String idBidan="";
    private String[] idBidanArray, namaBidanArray;
    private int i;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_ket_lahir);

        txtNoKetLhr = findViewById(R.id.txtNoKetLhr);
        txtTglLhr = findViewById(R.id.txtTglLhr);
        txtJamLhr = findViewById(R.id.txtJamLhr);
        txtKelahiranKe = findViewById(R.id.txtKelahiranKe);
        txtBerat = findViewById(R.id.txtBerat);
        txtPanjangBadan = findViewById(R.id.txtPanjangBadan);
        txtNamaTempatPersalinan = findViewById(R.id.txtNamaTempatPersalinan);
        txtAlamatTempatPersalinan = findViewById(R.id.txtAlamatTempatPersalinan);
        txtNamaAnak = findViewById(R.id.txtNamaAnak);
        txtSaksi1 = findViewById(R.id.txtSaksi1);
        txtSaksi2 = findViewById(R.id.txtSaksi2);
        txtNamaIbu = findViewById(R.id.txtNamaIbu);
        txtUmurIbu = findViewById(R.id.txtUmurIbu);
        txtPekerjaanIbu = findViewById(R.id.txtPekerjaanIbu);
        txtNIKIbu = findViewById(R.id.txtNIKIbu);
        txtNamaAyah = findViewById(R.id.txtNamaAyah);
        txtUmurAyah = findViewById(R.id.txtUmurAyah);
        txtNIKAyah = findViewById(R.id.txtNIKAyah);
        txtAlamat = findViewById(R.id.txtAlamat);
        txtKec = findViewById(R.id.txtKec);
        txtKab = findViewById(R.id.txtKab);

        cmbJK = findViewById(R.id.cmbJK);
        cmbJnsKelahiran = findViewById(R.id.cmbJnsKelahiran);
        cmbLahirDi = findViewById(R.id.cmbLahirDi);
        cmbPenolongPersalinan = findViewById(R.id.cmbPenolongPersalinan);

        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");
        spinnerArray.add("Laki-laki");
        spinnerArray.add("Perempuan");
        adapterJK = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapterJK.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbJK.setAdapter(adapterJK);

        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");
        spinnerArray.add("Tunggal");
        spinnerArray.add("Kembar 2");
        spinnerArray.add("Kembar 3");
        spinnerArray.add("Kembar 4");
        spinnerArray.add("Kembar 5");
        spinnerArray.add("Lainnya");
        adapterJnsKelahiran = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapterJnsKelahiran.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbJnsKelahiran.setAdapter(adapterJnsKelahiran);

        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");
        spinnerArray.add("Rumah Sakit");
        spinnerArray.add("Puskesmas");
        spinnerArray.add("Rumah Bersalin");
        spinnerArray.add("Polindes");
        spinnerArray.add("Rumah Bidan");
        adapterLahirDi = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapterLahirDi.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbLahirDi.setAdapter(adapterLahirDi);

        myCalendar = Calendar.getInstance();
        final DatePickerDialog.OnDateSetListener date = new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                myCalendar.set(Calendar.YEAR, year);
                myCalendar.set(Calendar.MONTH, month);
                myCalendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);
                updateLabel();
            }
        };
        txtTglLhr.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            @Override
            public void onFocusChange(View v, boolean hasFocus) {
                if (hasFocus) {
                    new DatePickerDialog(KetLahir.this, date, myCalendar.get(Calendar.YEAR), myCalendar.get(Calendar.MONTH), myCalendar.get(Calendar.DAY_OF_MONTH)).show();
                }
            }
        });

        txtJamLhr.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            @Override
            public void onFocusChange(View v, boolean hasFocus) {
                if (hasFocus){
                    Calendar mcurrentTime = Calendar.getInstance();
                    int hour = mcurrentTime.get(Calendar.HOUR_OF_DAY);
                    int minute = mcurrentTime.get(Calendar.MINUTE);
                    TimePickerDialog mTimePicker;
                    mTimePicker = new TimePickerDialog(KetLahir.this, new TimePickerDialog.OnTimeSetListener() {
                        @Override
                        public void onTimeSet(TimePicker timePicker, int selectedHour, int selectedMinute) {
                            txtJamLhr.setText( selectedHour + ":" + selectedMinute);
                        }
                    }, hour, minute, true);//Yes 24 hour time
                    mTimePicker.setTitle("Select Time");
                    mTimePicker.show();
                }
            }
        });

        ImageButton btnReload = findViewById(R.id.btnLoad);
        ImageButton btnKembali = findViewById(R.id.btnKembali);
        ImageButton btnSimpan = findViewById(R.id.btnSimpan);
        btnReload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                loadingKetLahir(MainActivity.idAnakTerpilih);
            }
        });
        btnKembali.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        btnSimpan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (txtTglLhr.getText().toString().equals("")){
                    Toast.makeText(KetLahir.this, "Masukkan tanggal lahir...", Toast.LENGTH_SHORT).show();
                    return;
                }
                else if (idBidan.equals("") || cmbPenolongPersalinan.getSelectedItemPosition() == 0){
                    Toast.makeText(KetLahir.this, "Pilih penolong persalinan...", Toast.LENGTH_SHORT).show();
                    return;
                }
                else if (cmbJnsKelahiran.getSelectedItemPosition() != 1){
                    Toast.makeText(KetLahir.this, "Registrasi pada aplikasi android hanya untuk jenis kelahiran TUNGGAL...", Toast.LENGTH_SHORT).show();
                    return;
                }
                simpanDataRegAnak();
            }
        });

        loadingKetLahir(MainActivity.idAnakTerpilih);
        cmbJnsKelahiran.setSelection(1);
    }

    private void updateLabel() {
        String myFormat = "yyyy/MM/dd"; //In which you need put here
        SimpleDateFormat sdf = new SimpleDateFormat(myFormat, Locale.US);

        txtTglLhr.setText(sdf.format(myCalendar.getTime()));
    }

    private void loadingKetLahir(String idAnak){
        disableStrictMode();
//        LoadingKetLahir mLoadingData = new LoadingKetLahir(KetLahir.this, idAnak);
//        mLoadingData.execute("");
        asyncTask.execute();
    }

    @SuppressLint("StaticFieldLeak")
    AsyncTask<String, Void, Boolean> asyncTask = new AsyncTask<String, Void, Boolean>() {
        @Override
        protected void onPreExecute() {
            progressDialog = new ProgressDialog(KetLahir.this);
            progressDialog.setMessage("retrieving...");
            progressDialog.setIndeterminate(false);
            progressDialog.setCancelable(false);
            progressDialog.show();
        }

        @Override
        protected Boolean doInBackground(String... strings) {
            boolean hasilRequest=false;
            try{
                ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                nameValuePairs.add(new BasicNameValuePair("idAnak", MainActivity.idAnakTerpilih));

                HttpParams httpParameters = new BasicHttpParams();

                HttpConnectionParams.setConnectionTimeout(httpParameters, 15000);
                HttpConnectionParams.setSoTimeout(httpParameters, 15000);

                HttpClient httpclient = new DefaultHttpClient(httpParameters);
                HttpPost httppost = new HttpPost(MainActivity.urlServer + "loadingKetLahir.php");
                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                HttpResponse response = httpclient.execute(httppost);
                HttpEntity entity = response.getEntity();

                String result = EntityUtils.toString(entity);

                hasilJsonObject = new JSONObject(result);
//                hasil = jsonObject.getString("isEmpty");
                System.out.println("hasilnya:" + hasilJsonObject);
//                JSONArray uName = jsonObject.getJSONArray("username");
//                sw = new String[uName.length()];
//                for (int x=0; x<uName.length(); x++){
//                    sw[x] = uName.getString(x);
//                }
                hasilRequest=true;
            }catch (Exception e){}

            return hasilRequest;
        }

        @Override
        protected void onPostExecute(Boolean valid) {
            progressDialog.dismiss();
            if (valid){
                try {
                    ekstrakJSON();
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                Toast.makeText(KetLahir.this, "Loading data selesai...", Toast.LENGTH_SHORT).show();
            }
            else{
                return;
            }
        }
    };

    private class LoadingKetLahir extends AsyncTask<String, Void, Boolean> {
        Context mContext = null;
        String user = "";

        Exception exception = null;

        LoadingKetLahir(Context context, String userName){
            mContext = context;
            user = userName;
        }

        @Override
        protected void onPreExecute() {
            progressDialog = new ProgressDialog(KetLahir.this);
            progressDialog.setMessage("retrieving...");
            progressDialog.setIndeterminate(false);
            progressDialog.setCancelable(false);
            progressDialog.show();
        }

        @Override
        protected Boolean doInBackground(String... arg0) {
            boolean hasilRequest=false;
            try{
                ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                nameValuePairs.add(new BasicNameValuePair("idAnak", user));

                HttpParams httpParameters = new BasicHttpParams();

                HttpConnectionParams.setConnectionTimeout(httpParameters, 15000);
                HttpConnectionParams.setSoTimeout(httpParameters, 15000);

                HttpClient httpclient = new DefaultHttpClient(httpParameters);
                HttpPost httppost = new HttpPost(MainActivity.urlServer + "loadingKetLahir.php");
                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                HttpResponse response = httpclient.execute(httppost);
                HttpEntity entity = response.getEntity();

                String result = EntityUtils.toString(entity);

                hasilJsonObject = new JSONObject(result);
//                hasil = jsonObject.getString("isEmpty");
                System.out.println("hasilnya:" + hasilJsonObject);
//                JSONArray uName = jsonObject.getJSONArray("username");
//                sw = new String[uName.length()];
//                for (int x=0; x<uName.length(); x++){
//                    sw[x] = uName.getString(x);
//                }
                hasilRequest=true;
            }catch (Exception e){
                Log.e("Error", "Error:", e);
                exception = e;
                hasilRequest=false;
            }

            return hasilRequest;
        }

        @Override
        protected void onPostExecute(Boolean valid){
            //StopWord = sw;
            //BtnProses.setEnabled(true);
            progressDialog.dismiss();
            if (valid){
                try {
                    ekstrakJSON();
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                Toast.makeText(mContext, "Loading data selesai...", Toast.LENGTH_SHORT).show();
            }
            else{
                return;
            }

        }

    }

    public static void disableStrictMode() {
        // StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
        // StrictMode.setThreadPolicy(policy);

        try {
            Class<?> strictModeClass = Class.forName("android.os.StrictMode", true, Thread.currentThread().getContextClassLoader());
            Class<?> threadPolicyClass = Class.forName("android.os.StrictMode$ThreadPolicy", true, Thread .currentThread().getContextClassLoader());
            Class<?> threadPolicyBuilderClass = Class.forName("android.os.StrictMode$ThreadPolicy$Builder", true, Thread.currentThread().getContextClassLoader());

            Method setThreadPolicyMethod = strictModeClass.getMethod("setThreadPolicy", threadPolicyClass);

            Method detectAllMethod = threadPolicyBuilderClass.getMethod("detectAll");
            Method penaltyMethod = threadPolicyBuilderClass.getMethod("penaltyLog");
            Method buildMethod = threadPolicyBuilderClass.getMethod("build");

            Constructor<?> threadPolicyBuilderConstructor = threadPolicyBuilderClass.getConstructor();
            Object threadPolicyBuilderObject = threadPolicyBuilderConstructor.newInstance();

            Object obj = detectAllMethod.invoke(threadPolicyBuilderObject);

            obj = penaltyMethod.invoke(obj);
            Object threadPolicyObject = buildMethod.invoke(obj);
            setThreadPolicyMethod.invoke(strictModeClass, threadPolicyObject);
        }
        catch (Exception ex) {
            Log.w("disableStrictMode", ex);
        }
    }

    private void ekstrakJSON() throws JSONException {
        txtNoKetLhr.setText(ambilDataJSON("no_ket_lahir"));
        txtTglLhr.setText(ambilDataJSON("tgl_lahir"));
        txtJamLhr.setText(ambilDataJSON("waktu_lahir"));
        txtKelahiranKe.setText(ambilDataJSON("kelahiran_ke"));
        txtBerat.setText(ambilDataJSON("berat_lahir"));
        txtPanjangBadan.setText(ambilDataJSON("panjang_badan"));
        txtNamaTempatPersalinan.setText(ambilDataJSON("nama_tempat_lahir"));
        txtAlamatTempatPersalinan.setText(ambilDataJSON("alamat_tempat_lahir"));
        txtNamaAnak.setText(ambilDataJSON("nama_anak"));
        txtSaksi1.setText(ambilDataJSON("nama_saksi1"));
        txtSaksi2.setText(ambilDataJSON("nama_saksi2"));
        txtNamaIbu.setText(ambilDataJSON("nama"));
        txtUmurIbu.setText(ambilDataJSON("umur_ibu"));
        txtPekerjaanIbu.setText(ambilDataJSON("pekerjaan"));
        txtNIKIbu.setText(ambilDataJSON("nik"));
        txtNamaAyah.setText(ambilDataJSON("nama_suami"));
        txtUmurAyah.setText(ambilDataJSON("umur_ayah"));
        txtNIKAyah.setText(ambilDataJSON("nik_suami"));
        txtAlamat.setText(ambilDataJSON("alamat_rumah"));
        txtKec.setText(ambilDataJSON("kecamatan"));
        txtKab.setText(ambilDataJSON("kabupaten"));

        if (!ambilDataJSON("jk").equals("") ){
            cmbJK.setSelection(adapterJK.getPosition(ambilDataJSON("jk")));
        }
        if (!ambilDataJSON("jns_kelahiran").equals("") ){
            cmbJnsKelahiran.setSelection(adapterJnsKelahiran.getPosition(ambilDataJSON("jns_kelahiran")));
        }
        if (!ambilDataJSON("tempat_lahir").equals("") ){
            cmbLahirDi.setSelection(adapterLahirDi.getPosition(ambilDataJSON("tempat_lahir")));
        }

        //spinner penolong persalinan
        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");

        jsonArray = hasilJsonObject.getJSONArray("id_bidan_array");
        idBidanArray = new String[jsonArray.length()];
        for(i=0; i<jsonArray.length(); i++){
            idBidanArray[i] = jsonArray.getString(i);
        }
        jsonArray = hasilJsonObject.getJSONArray("nama_bidan_array");
        namaBidanArray = new String[jsonArray.length()];
        for(i=0; i<jsonArray.length(); i++){
            namaBidanArray[i] = jsonArray.getString(i);
            spinnerArray.add(namaBidanArray[i]);
        }
        adapterPenolongPersalinan = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapterPenolongPersalinan.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbPenolongPersalinan = findViewById(R.id.cmbPenolongPersalinan);
        cmbPenolongPersalinan.setAdapter(adapterPenolongPersalinan);
        cmbPenolongPersalinan.setSelection(adapterPenolongPersalinan.getPosition(ambilDataJSON("nama_bidan")));
        cmbPenolongPersalinan.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                if (position > 0){
                    idBidan = idBidanArray[position-1];
                    System.out.println("Posisi: " + idBidan);
                }

            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {
                return;
            }
        });
        //------------------------------------------------------------------------------------------
    }

    private String ambilDataJSON(String field) throws JSONException {
        String hasil = null;
        hasil = hasilJsonObject.getString(field);
        if (hasil.equals("null")) hasil = "";
        return hasil;
    }

    private void simpanDataRegAnak(){
        disableStrictMode();
        SimpanDataRegAnak mSimpanData = new SimpanDataRegAnak(KetLahir.this);
        mSimpanData.execute("");
    }

    private class SimpanDataRegAnak extends AsyncTask<String, Void, Boolean> {
        Context mContext = null;

        Exception exception = null;

        SimpanDataRegAnak(Context context){
            mContext = context;
        }

        @Override
        protected void onPreExecute() {
            progressDialog = new ProgressDialog(KetLahir.this);
            progressDialog.setMessage("Menyimpan data...");
            progressDialog.setIndeterminate(false);
            progressDialog.setCancelable(false);
            progressDialog.show();
        }

        @SuppressLint("WrongThread")
        @Override
        protected Boolean doInBackground(String... arg0) {
            boolean hasilRequest=false;
            try{
                ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                nameValuePairs.add(new BasicNameValuePair("txtNoKetLhr", txtNoKetLhr.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("cmbJK", cmbJK.getSelectedItem().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtTglLhr", txtTglLhr.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtJam", txtJamLhr.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("cmbJnsKelahiran", cmbJnsKelahiran.getSelectedItem().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtKelahiranKe", txtKelahiranKe.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtBerat", txtBerat.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtTinggi", txtPanjangBadan.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("cmbBersalin", cmbLahirDi.getSelectedItem().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtNamaTempatPersalinan", txtNamaTempatPersalinan.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtAlamatTempatPersalinan", txtAlamatTempatPersalinan.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtNamaAnak", txtNamaAnak.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtSaksi1", txtSaksi1.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtSaksi2", txtSaksi2.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("cmbPenolongPersalinan", idBidan));
                nameValuePairs.add(new BasicNameValuePair("txtUmurIbu", txtUmurIbu.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtUmurAyah", txtUmurAyah.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtIdAnak", MainActivity.idAnakTerpilih));

                HttpParams httpParameters = new BasicHttpParams();

                HttpConnectionParams.setConnectionTimeout(httpParameters, 15000);
                HttpConnectionParams.setSoTimeout(httpParameters, 15000);

                HttpClient httpclient = new DefaultHttpClient(httpParameters);
                HttpPost httppost = new HttpPost(MainActivity.urlServer + "simpanKetLahirAndroid.php");
                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                HttpResponse response = httpclient.execute(httppost);
                HttpEntity entity = response.getEntity();

                String result = EntityUtils.toString(entity);

                hasilJsonObject = new JSONObject(result);
                System.out.println("Hasil response simpan: " + result);
//                hasil = jsonObject.getString("isEmpty");
//                System.out.println("hasilnya:" + hasil);
//                JSONArray uName = jsonObject.getJSONArray("username");
//                sw = new String[uName.length()];
//                for (int x=0; x<uName.length(); x++){
//                    sw[x] = uName.getString(x);
//                }
                hasilRequest=true;
            }catch (Exception e){
                Log.e("Error", "Error:", e);
                exception = e;
                hasilRequest=false;
            }

            return hasilRequest;
        }

        @Override
        protected void onPostExecute(Boolean valid){
            //StopWord = sw;
            //BtnProses.setEnabled(true);
            progressDialog.dismiss();
            if(valid){
                try {
                    if (hasilJsonObject.getString("isOk").equals("true"))
                        Toast.makeText(mContext, "Simpan data selesai...", Toast.LENGTH_SHORT).show();

                    else
                        Toast.makeText(mContext, "Simpan data gagal...", Toast.LENGTH_SHORT).show();
                } catch (JSONException e) {
                    System.out.print("ada error");
                    e.printStackTrace();
                }
            }
            else{
                return;
            }
        }

    }
}
