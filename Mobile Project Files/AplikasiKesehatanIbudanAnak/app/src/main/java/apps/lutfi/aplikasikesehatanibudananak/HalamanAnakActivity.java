package apps.lutfi.aplikasikesehatanibudananak;

import android.annotation.SuppressLint;
import android.support.v4.view.PagerAdapter;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.TextView;

import com.koushikdutta.ion.Ion;

public class HalamanAnakActivity extends AppCompatActivity {

    @SuppressLint("StaticFieldLeak")
    private static TextView tv1, judul;
    private static int halaman;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        getSupportActionBar().hide();
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_halaman_anak);

        final ViewPager viewPager = findViewById(R.id.viewPagerBro);

        viewPager.setAdapter(new SamplePagerAdapter());
        PageListener pl = new PageListener();
        //noinspection deprecation
        viewPager.setOnPageChangeListener(pl);

        tv1 = (TextView) findViewById(R.id.textView);
        tv1.setText("Halaman: "+String.valueOf(1));

        judul = findViewById(R.id.txtLabel);

        ImageButton btnKanan = findViewById(R.id.btnKanan);
        btnKanan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                halaman = viewPager.getCurrentItem();
                if (halaman < 30){
                    viewPager.setCurrentItem(halaman+1);
                }
            }
        });

        ImageButton btnKiri = findViewById(R.id.btnKiri);
        btnKiri.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (viewPager.getCurrentItem() > 0)
                    viewPager.setCurrentItem(viewPager.getCurrentItem()-1);
            }
        });

        viewPager.setCurrentItem(MainActivity.halaman);
        judul.setText(MainActivity.judul);
    }

    private static class SamplePagerAdapter extends PagerAdapter {

        private static final String[] sDrawables = {
                "hal032.png",
                "hal033.png",
                "hal034.png",
                "hal035.png",
                "hal036.png",
                "hal037.png",
                "hal040.png",
                "hal041.png",
                "hal042.png",
                "hal043.png",
                "hal044.png",
                "hal045.png",
                "hal046.png",
                "hal047.png",
                "hal048.png",
                "hal049.png",
                "hal050.png",
                "hal051.png",
                "hal052.png",
                "hal053.png",
                "hal054.png",
                "hal055.png",
                "hal056.png",
                "hal057.png",
                "hal058.png",
                "hal059.png",
                "hal060.png",
                "hal061.png",
                "hal062.png",
                "hal063.png",
                "hal064.png"

        };

        @Override
        public int getCount() {
            return sDrawables.length;
        }

        @Override
        public View instantiateItem(ViewGroup container, int position) {
            System.out.println("Halaman : " + position);
            //PhotoView tiv = null;
            TouchImageView tiv = null;
            try {

                //tiv = new PhotoView(container.getContext());
                //tiv.setMaximumScale(16f);
                // tiv.setMediumScale(-999);
                tiv = new TouchImageView(container.getContext());
                tiv.setMaxZoom(16f);
                //System.out.println(tiv.getMaxZoom());
                Ion.with(container.getContext())
                        .load("file:///android_asset/" + sDrawables[position])
                        .setLogging("DeepZoom", Log.VERBOSE)
                        .withBitmap()
                        .deepZoom()
                        .intoImageView(tiv);

                // Now just add PhotoView to ViewPager and return it
                container.addView(tiv, ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.MATCH_PARENT);
            } catch (Exception e) {
                e.printStackTrace();
            }

            System.out.println("Jumlah: " + getCount());
            return tiv;
        }

        @Override
        public void destroyItem(ViewGroup container, int position, Object object) {
            container.removeView((View) object);
        }

        @Override
        public boolean isViewFromObject(View view, Object object) {
            return view == object;
        }
    }

    private static class PageListener extends ViewPager.SimpleOnPageChangeListener {
        public void onPageSelected(int position) {
            tv1.setText("Halaman: "+String.valueOf(position+1));
            halaman = position;
            if (halaman >=0 && halaman <=5) judul.setText("Bayi Baru Lahir/Neonatus (0-28hari)");
            else if (halaman >=6 && halaman <=15) judul.setText("Anak Usia 29 Hari s.d. 6 Tahun");
            else if (halaman >=16 && halaman <=30) judul.setText("Pemenuhan kebutuhan Gizi & Perkembangan Anak");
        }
    }
}
