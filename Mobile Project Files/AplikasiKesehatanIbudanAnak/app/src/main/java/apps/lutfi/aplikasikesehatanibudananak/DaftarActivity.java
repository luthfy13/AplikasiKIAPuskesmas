package apps.lutfi.aplikasikesehatanibudananak;

import android.annotation.SuppressLint;
import android.app.DatePickerDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.support.design.widget.TextInputEditText;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.DatePicker;
import android.widget.ImageButton;
import android.widget.Spinner;
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

public class DaftarActivity extends AppCompatActivity {
    private Calendar myCalendar;
    private TextInputEditText txtNoReg, txtNama, txtTempatLahir, txtTglLahir, txtPekerjaan, txtNoJKN,
            txtNIKSuami, txtNamaSuami, txtTempatLahirSuami, txtTglLahirSuami, txtPekerjaanSuami,
            txtAlamatRumah, txtTelp, txtKehamilanKe, txtUmurAnakTerakhir;

    private Spinner cmbAgama,
            cmbAgamaSuami,
            cmbGolDarah,
            cmbGolDarahSuami,
            cmbPendidikan,
            cmbPendidikanSuami,
            cmbBidan,
            cmbKab, cmbKec;

    private List<String> spinnerArray = null;
    private ArrayAdapter<String> adapter = null;
    private ProgressDialog progressDialog;
    private JSONObject hasilJsonObject = null;
    private String hasil=null;
    private String[] idBidanArray, namaBidanArray, idKabArray, namaKabArray, idKecArray,
            namaKecArray, idKecArrayTerpilih, namaKecArrayTerpilih;
    private int i,j;
    private JSONArray jsonArray;
    private String idBidan, idKab, idKec;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_daftar);

        myCalendar = Calendar.getInstance();
        //tgl lahir ibu
        txtTglLahir = findViewById(R.id.txtTglLahir);
        final DatePickerDialog.OnDateSetListener date = new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                myCalendar.set(Calendar.YEAR, year);
                myCalendar.set(Calendar.MONTH, month);
                myCalendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);
                updateLabel();
            }
        };

        txtTglLahir.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            @Override
            public void onFocusChange(View v, boolean hasFocus) {
                if (hasFocus) {
                    new DatePickerDialog(DaftarActivity.this, date, myCalendar.get(Calendar.YEAR), myCalendar.get(Calendar.MONTH), myCalendar.get(Calendar.DAY_OF_MONTH)).show();
                }
            }
        });

        //tgl lahir suami
        txtTglLahirSuami = findViewById(R.id.txtTglLahirSuami);
        final DatePickerDialog.OnDateSetListener dateSuami = new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                myCalendar.set(Calendar.YEAR, year);
                myCalendar.set(Calendar.MONTH, month);
                myCalendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);
                updateLabelSuami();
            }
        };

        txtTglLahirSuami.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            @Override
            public void onFocusChange(View v, boolean hasFocus) {
                if (hasFocus) {
                    new DatePickerDialog(DaftarActivity.this, dateSuami, myCalendar.get(Calendar.YEAR), myCalendar.get(Calendar.MONTH), myCalendar.get(Calendar.DAY_OF_MONTH)).show();
                }
            }
        });

        //SPINNER a.k.a. comboBOX

        //spinner Agama
        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");
        spinnerArray.add("Islam");
        spinnerArray.add("Kristen Protestan");
        spinnerArray.add("Kristen Katolik");
        spinnerArray.add("Hindu");
        spinnerArray.add("Buddha");
        spinnerArray.add("Konghucu");
        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbAgama = findViewById(R.id.cmbAgama);
        cmbAgama.setAdapter(adapter);
        cmbAgamaSuami = findViewById(R.id.cmbAgamaSuami);
        cmbAgamaSuami.setAdapter(adapter);

        //spinner Pendidikan
        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");
        spinnerArray.add("Tidak Sekolah");
        spinnerArray.add("SD");
        spinnerArray.add("SMP");
        spinnerArray.add("SMU");
        spinnerArray.add("Akademi");
        spinnerArray.add("Perguruan Tinggi");
        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbPendidikan = findViewById(R.id.cmbPendidikan);
        cmbPendidikan.setAdapter(adapter);
        cmbPendidikanSuami = findViewById(R.id.cmbPendidikanSuami);
        cmbPendidikanSuami.setAdapter(adapter);

        //spinner Golongan Darah
        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");
        spinnerArray.add("0");
        spinnerArray.add("A");
        spinnerArray.add("B");
        spinnerArray.add("AB");
        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbGolDarah = findViewById(R.id.cmbGolDarah);
        cmbGolDarah.setAdapter(adapter);
        cmbGolDarahSuami = findViewById(R.id.cmbGolDarahSuami);
        cmbGolDarahSuami.setAdapter(adapter);

        //----------------------------------------------------------------------------------------------------

        txtNoReg = findViewById(R.id.txtNoReg);
        txtNama = findViewById(R.id.txtNama);
        txtTempatLahir = findViewById(R.id.txtTempatLahir);
        txtPekerjaan = findViewById(R.id.txtPekerjaan);
        txtNoJKN = findViewById(R.id.txtNoJKN);
        txtNIKSuami = findViewById(R.id.txtNIKSuami);
        txtNamaSuami = findViewById(R.id.txtNamaSuami);
        txtTempatLahirSuami = findViewById(R.id.txtTempatLahirSuami);
        txtPekerjaanSuami = findViewById(R.id.txtPekerjaanSuami);
        txtAlamatRumah = findViewById(R.id.txtAlamatRumah);
        txtTelp = findViewById(R.id.txtTelp);
        txtKehamilanKe = findViewById(R.id.txtKehamilanKe);
        txtUmurAnakTerakhir = findViewById(R.id.txtUmurAnakTerakhir);

        //----------------------------------------------------------------------------------------------------

        ImageButton btnLoad = findViewById(R.id.btnLoad);
        ImageButton btnSimpan = findViewById(R.id.btnSimpan);
        ImageButton btnKembali = findViewById(R.id.btnKembali);
        btnKembali.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        //event Button
        btnLoad.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                loadingDataReg(MainActivity.username);
            }
        });

        btnSimpan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                simpanDataReg();
            }
        });

        //-------------------------------------------------------------------------------------------------



        loadingDataReg(MainActivity.username);
    }

    private void updateLabel() {
        String myFormat = "yyyy/MM/dd"; //In which you need put here
        SimpleDateFormat sdf = new SimpleDateFormat(myFormat, Locale.US);

        txtTglLahir.setText(sdf.format(myCalendar.getTime()));
    }

    private void updateLabelSuami() {
        String myFormat = "yyyy/MM/dd"; //In which you need put here
        SimpleDateFormat sdf = new SimpleDateFormat(myFormat, Locale.US);

        txtTglLahirSuami.setText(sdf.format(myCalendar.getTime()));
    }

    private void loadingDataReg(String userName){
        disableStrictMode();
        LoadingDataReg mLoadingData = new LoadingDataReg(DaftarActivity.this, userName);
        mLoadingData.execute("");
    }

    private class LoadingDataReg extends AsyncTask<String, Void, Boolean> {
        Context mContext = null;
        String user = "";
        String pass = "";

        Exception exception = null;

        LoadingDataReg(Context context, String userName){
            mContext = context;
            user = userName;
        }

        @Override
        protected void onPreExecute() {
            progressDialog = new ProgressDialog(DaftarActivity.this);
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
                nameValuePairs.add(new BasicNameValuePair("txtUser", user));

                HttpParams httpParameters = new BasicHttpParams();

                HttpConnectionParams.setConnectionTimeout(httpParameters, 15000);
                HttpConnectionParams.setSoTimeout(httpParameters, 15000);

                HttpClient httpclient = new DefaultHttpClient(httpParameters);
                HttpPost httppost = new HttpPost(MainActivity.urlServer + "loadingDataRegIbu.php");
                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                HttpResponse response = httpclient.execute(httppost);
                HttpEntity entity = response.getEntity();

                String result = EntityUtils.toString(entity);

                hasilJsonObject = new JSONObject(result);
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
                    ekstrakJSON();
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                Toast.makeText(mContext, "Loading data selesai...", Toast.LENGTH_LONG).show();
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
        //EditText
        txtNoReg.setText(ambilDataJSON("no_reg"));
        txtNama.setText(ambilDataJSON("nama"));
        txtTempatLahir.setText(ambilDataJSON("tempat_lahir"));
        txtTglLahir.setText(ambilDataJSON("tgl_lahir"));
        txtPekerjaan.setText(ambilDataJSON("pekerjaan"));
        txtNoJKN.setText(ambilDataJSON("no_jkn"));
        txtNIKSuami.setText(ambilDataJSON("nik_suami"));
        txtNamaSuami.setText(ambilDataJSON("nama_suami"));
        txtTempatLahirSuami.setText(ambilDataJSON("tempat_lahir_suami"));
        txtTglLahirSuami.setText(ambilDataJSON("tgl_lahir_suami"));
        txtPekerjaanSuami.setText(ambilDataJSON("pekerjaan_suami"));
        txtAlamatRumah.setText(ambilDataJSON("alamat_rumah"));
        txtTelp.setText(ambilDataJSON("telp"));
        txtKehamilanKe.setText(ambilDataJSON("kehamilan_ke"));
        txtUmurAnakTerakhir.setText(ambilDataJSON("umur_anak_terakhir"));
        idKab = ambilDataJSON("id_kab");
        idKec = ambilDataJSON("id_kec");
        //------------------------------------------------------------------------------------------

        //spinner agama
        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");
        spinnerArray.add("Islam");
        spinnerArray.add("Kristen Protestan");
        spinnerArray.add("Kristen Katolik");
        spinnerArray.add("Hindu");
        spinnerArray.add("Buddha");
        spinnerArray.add("Konghucu");
        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbAgama = findViewById(R.id.cmbAgama);
        cmbAgama.setAdapter(adapter);
        cmbAgamaSuami = findViewById(R.id.cmbAgamaSuami);
        cmbAgamaSuami.setAdapter(adapter);
        cmbAgama.setSelection(adapter.getPosition(ambilDataJSON("agama")));
        cmbAgamaSuami.setSelection(adapter.getPosition(ambilDataJSON("agama_suami")));
        //------------------------------------------------------------------------------------------

        //spinner pendidikan
        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");
        spinnerArray.add("Tidak Sekolah");
        spinnerArray.add("SD");
        spinnerArray.add("SMP");
        spinnerArray.add("SMU");
        spinnerArray.add("Akademi");
        spinnerArray.add("Perguruan Tinggi");
        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbPendidikan = findViewById(R.id.cmbPendidikan);
        cmbPendidikan.setAdapter(adapter);
        cmbPendidikanSuami = findViewById(R.id.cmbPendidikanSuami);
        cmbPendidikanSuami.setAdapter(adapter);
        cmbPendidikan.setSelection(adapter.getPosition(ambilDataJSON("pendidikan")));
        cmbPendidikanSuami.setSelection(adapter.getPosition(ambilDataJSON("pendidikan_suami")));
        //------------------------------------------------------------------------------------------

        //spinner gol darah
        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");
        spinnerArray.add("0");
        spinnerArray.add("A");
        spinnerArray.add("B");
        spinnerArray.add("AB");
        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbGolDarah = findViewById(R.id.cmbGolDarah);
        cmbGolDarah.setAdapter(adapter);
        cmbGolDarahSuami = findViewById(R.id.cmbGolDarahSuami);
        cmbGolDarahSuami.setAdapter(adapter);
        cmbGolDarah.setSelection(adapter.getPosition(ambilDataJSON("gol_darah")));
        cmbGolDarahSuami.setSelection(adapter.getPosition(ambilDataJSON("gol_darah_suami")));
        //------------------------------------------------------------------------------------------

        //id dan nama bidan
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

        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbBidan = findViewById(R.id.cmbBidan);
        cmbBidan.setAdapter(adapter);
        cmbBidan.setSelection(adapter.getPosition(ambilDataJSON("nama_bidan")));
        cmbBidan.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                if (position > 0){
                    idBidan = idBidanArray[position-1];
                    System.out.println("Posisi: " + idBidan);
                }

            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
        //------------------------------------------------------------------------------------------

        //id dan nama kab
        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");

        jsonArray = hasilJsonObject.getJSONArray("id_kab_array");
        idKabArray = new String[jsonArray.length()];
        for(i=0; i<jsonArray.length(); i++){
            idKabArray[i] = jsonArray.getString(i);
        }

        jsonArray = hasilJsonObject.getJSONArray("nama_kab_array");
        namaKabArray = new String[jsonArray.length()];
        for(i=0; i<jsonArray.length(); i++){
            namaKabArray[i] = jsonArray.getString(i);
            spinnerArray.add(namaKabArray[i]);
        }

        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbKab = findViewById(R.id.cmbKab);
        cmbKab.setAdapter(adapter);
        cmbKab.setSelection(adapter.getPosition(ambilDataJSON("kabupaten")), false);
        cmbKab.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                if (position > 0){
                    idKab = idKabArray[position-1];
                    System.out.println("Posisi Kab: " + idKab + ", id: " + id);

                    j=0;
                    spinnerArray = new ArrayList<String>();
                    spinnerArray.add("-PILIH-");
                    for(i=0; i<idKecArray.length; i++){
                        if (idKecArray[i].substring(0,4).equals(idKab)) j++;
                    }
                    idKecArrayTerpilih = new String[j];
                    namaKecArrayTerpilih = new String[j];
                    j=0;
                    for(i=0; i<namaKecArray.length; i++){
                        if (idKecArray[i].substring(0,4).equals(idKab)) {
                            idKecArrayTerpilih[j] = idKecArray[i];
                            namaKecArrayTerpilih[j] = namaKecArray[i];
                            spinnerArray.add(namaKecArrayTerpilih[j]);
                            j++;
                        }
                    }

                    adapter = new ArrayAdapter<String>(getApplicationContext(), android.R.layout.simple_spinner_item, spinnerArray);
                    adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                    cmbKec = findViewById(R.id.cmbKec);
                    cmbKec.setAdapter(adapter);
                    cmbKec.setSelection(0);
                }

            }
            @Override
            public void onNothingSelected(AdapterView<?> parent) {
                return;
            }
        });
        //------------------------------------------------------------------------------------------

        //id dan nama kec
        j=0;
        spinnerArray = new ArrayList<String>();
        spinnerArray.add("-PILIH-");

        jsonArray = hasilJsonObject.getJSONArray("id_kec_array");
        idKecArray = new String[jsonArray.length()];
        for(i=0; i<jsonArray.length(); i++){
            idKecArray[i] = jsonArray.getString(i);
            if (idKecArray[i].substring(0,4).equals(ambilDataJSON("id_kab"))) j++;
        }

        jsonArray = hasilJsonObject.getJSONArray("nama_kec_array");
        namaKecArray = new String[jsonArray.length()];
        idKecArrayTerpilih = new String[j];
        namaKecArrayTerpilih = new String[j];
        j=0;
        for(i=0; i<jsonArray.length(); i++){
            namaKecArray[i] = jsonArray.getString(i);
            if (idKecArray[i].substring(0,4).equals(ambilDataJSON("id_kab"))) {
                idKecArrayTerpilih[j] = idKecArray[i];
                namaKecArrayTerpilih[j] = namaKecArray[i];
                spinnerArray.add(namaKecArrayTerpilih[j]);
                j++;
            }
        }

        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, spinnerArray);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        cmbKec = findViewById(R.id.cmbKec);
        cmbKec.setAdapter(adapter);
        cmbKec.setSelection(adapter.getPosition(ambilDataJSON("kecamatan")));
        cmbKec.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                if (position > 0){
                    idKec = idKecArrayTerpilih[position-1];
                    System.out.println("Posisi Kec: " + idKec);
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

    //simpan data
    private void simpanDataReg(){
        disableStrictMode();
        SimpanDataReg mSimpanData = new SimpanDataReg(DaftarActivity.this);
        mSimpanData.execute("");
    }

    private class SimpanDataReg extends AsyncTask<String, Void, Boolean> {
        Context mContext = null;

        Exception exception = null;

        SimpanDataReg(Context context){
            mContext = context;
        }

        @Override
        protected void onPreExecute() {
            progressDialog = new ProgressDialog(DaftarActivity.this);
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
                nameValuePairs.add(new BasicNameValuePair("id_bidan", idBidan));
                nameValuePairs.add(new BasicNameValuePair("nama", txtNama.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("tempat_lahir", txtTempatLahir.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("tgl_lahir", txtTglLahir.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("kehamilan_ke", txtKehamilanKe.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("umur_anak_terakhir", txtUmurAnakTerakhir.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("agama", cmbAgama.getSelectedItem().toString()));
                nameValuePairs.add(new BasicNameValuePair("pendidikan", cmbPendidikan.getSelectedItem().toString()));
                nameValuePairs.add(new BasicNameValuePair("gol_darah", cmbGolDarah.getSelectedItem().toString()));
                nameValuePairs.add(new BasicNameValuePair("pekerjaan", txtPekerjaan.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("no_jkn", txtNoJKN.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("nik_suami", txtNIKSuami.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("nama_suami", txtNamaSuami.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("tempat_lahir_suami", txtTempatLahirSuami.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("tgl_lahir_suami", txtTglLahirSuami.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("agama_suami", cmbAgamaSuami.getSelectedItem().toString()));
                nameValuePairs.add(new BasicNameValuePair("pendidikan_suami", cmbPendidikanSuami.getSelectedItem().toString()));
                nameValuePairs.add(new BasicNameValuePair("gol_darah_suami", cmbGolDarahSuami.getSelectedItem().toString()));
                nameValuePairs.add(new BasicNameValuePair("pekerjaan_suami", txtPekerjaanSuami.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("alamat_rumah", txtAlamatRumah.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("id_kab", idKab));
                nameValuePairs.add(new BasicNameValuePair("id_kec", idKec));
                nameValuePairs.add(new BasicNameValuePair("telp", txtTelp.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("username", MainActivity.username));

                HttpParams httpParameters = new BasicHttpParams();

                HttpConnectionParams.setConnectionTimeout(httpParameters, 15000);
                HttpConnectionParams.setSoTimeout(httpParameters, 15000);

                HttpClient httpclient = new DefaultHttpClient(httpParameters);
                HttpPost httppost = new HttpPost(MainActivity.urlServer + "simpanRegistrasi.php");
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
                        Toast.makeText(mContext, "Simpan data selesai...", Toast.LENGTH_LONG).show();

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
