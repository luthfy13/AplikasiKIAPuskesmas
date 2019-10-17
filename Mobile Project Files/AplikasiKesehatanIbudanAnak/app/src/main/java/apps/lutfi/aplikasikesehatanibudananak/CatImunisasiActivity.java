package apps.lutfi.aplikasikesehatanibudananak;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ImageButton;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

public class CatImunisasiActivity extends AppCompatActivity {
    private WebView wv1;
    private String postData = "";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cat_imunisasi);

        wv1 = (WebView) findViewById(R.id.webview);
        loadData();

        ImageButton btnReload = findViewById(R.id.btnLoad);
        btnReload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                loadData();
            }
        });

        ImageButton btnKembali = findViewById(R.id.btnKembali);
        btnKembali.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
    }

    private void loadData(){
        wv1.setWebViewClient(new MyBrowser());
        wv1.getSettings().setLoadsImagesAutomatically(true);
        wv1.getSettings().setJavaScriptEnabled(true);
        wv1.setScrollBarStyle(View.SCROLLBARS_INSIDE_OVERLAY);

        try {
            postData = "noKetLahir=" + URLEncoder.encode(MainActivity.idAnakTerpilih, "UTF-8");
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
        }
        wv1.postUrl(MainActivity.urlServer + "loadCatImunisasi.php", postData.getBytes());
    }

    private class MyBrowser extends WebViewClient {
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
            view.loadUrl(url);
            return true;
        }
    }
}
