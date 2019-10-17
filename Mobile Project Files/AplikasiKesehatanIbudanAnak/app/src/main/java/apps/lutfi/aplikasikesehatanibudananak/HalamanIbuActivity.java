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

public class HalamanIbuActivity extends AppCompatActivity {

    @SuppressLint("StaticFieldLeak")
    private static TextView tv1, judul;
    private static int halaman;

    @SuppressLint("SetTextI18n")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        getSupportActionBar().hide();
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_halaman_ibu);

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
                if (halaman < 17){
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
                "hal001.png",
                "hal002.png",
                "hal003.png",
                "hal004.png",
                "hal005.png",
                "hal006.png",
                "hal007.png",
                "hal008.png",
                "hal009.png",
                "hal010.png",
                "hal011.png",
                "hal012.png",
                "hal013.png",
                "hal014.png",
                "hal015.png",
                "hal016.png",
                "hal017.png",
                "hal018.png"

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
            if (halaman >=0 && halaman <=8) judul.setText("Informasi Ibu Hamil");
            else if (halaman >=9 && halaman <=11) judul.setText("Informasi Ibu Bersalin");
            else if (halaman >=12 && halaman <=16) judul.setText("Informasi Ibu Nifas");
            else if (halaman == 17) judul.setText("Informasi Keluarga Berencana");
        }
    }
}
