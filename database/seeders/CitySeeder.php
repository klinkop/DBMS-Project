<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // Johor cities
            ['name' => 'Johor Bahru', 'state_id' => 1],
            ['name' => 'Iskandar Puteri', 'state_id' => 1],
            ['name' => 'Pasir Gudang', 'state_id' => 1],
            ['name' => 'Skudai', 'state_id' => 1],
            ['name' => 'Kulai', 'state_id' => 1],
            ['name' => 'Pontian', 'state_id' => 1],
            ['name' => 'Kluang', 'state_id' => 1],
            ['name' => 'Mersing', 'state_id' => 1],
            ['name' => 'Kota Tinggi', 'state_id' => 1],
            ['name' => 'Segamat', 'state_id' => 1],
            ['name' => 'Muar', 'state_id' => 1],
            ['name' => 'Batu Pahat', 'state_id' => 1],
            ['name' => 'Yong Peng', 'state_id' => 1],
            ['name' => 'Ayer Hitam', 'state_id' => 1],
            ['name' => 'Simpang Renggam', 'state_id' => 1],
            ['name' => 'Rengit', 'state_id' => 1],
            ['name' => 'Labis', 'state_id' => 1],
            ['name' => 'Chaah', 'state_id' => 1],
            ['name' => 'Bekok', 'state_id' => 1],
            ['name' => 'Kukup', 'state_id' => 1],
            ['name' => 'Pagoh', 'state_id' => 1],
            ['name' => 'Bukit Pasir', 'state_id' => 1],
            ['name' => 'Mengkibol', 'state_id' => 1],
            ['name' => 'Paloh', 'state_id' => 1],
            ['name' => 'Pekan Nanas', 'state_id' => 1],
            ['name' => 'Benut', 'state_id' => 1],
            ['name' => 'Pengerang', 'state_id' => 1],
            ['name' => 'Sedili', 'state_id' => 1],
            ['name' => 'Endau', 'state_id' => 1],
            ['name' => 'Penyabong', 'state_id' => 1],

            // Kedah cities
            ['name' => 'Alor Setar', 'state_id' => 2],
            ['name' => 'Sungai Petani', 'state_id' => 2],
            ['name' => 'Kuala Kedah', 'state_id' => 2],
            ['name' => 'Kulim', 'state_id' => 2],
            ['name' => 'Baling', 'state_id' => 2],
            ['name' => 'Sik', 'state_id' => 2],
            ['name' => 'Padang Terap', 'state_id' => 2],
            ['name' => 'Kota Sarang Semut', 'state_id' => 2],
            ['name' => 'Pendang', 'state_id' => 2],
            ['name' => 'Langkawi', 'state_id' => 2],
            ['name' => 'Kuah', 'state_id' => 2],
            ['name' => 'Kubang Pasu', 'state_id' => 2],
            ['name' => 'Pokok Sena', 'state_id' => 2],
            ['name' => 'Yan', 'state_id' => 2],
            ['name' => 'Merbok', 'state_id' => 2],
            ['name' => 'Tikam Batu', 'state_id' => 2],
            ['name' => 'Lunas', 'state_id' => 2],
            ['name' => 'Bandar Baharu', 'state_id' => 2],
            ['name' => 'Gurun', 'state_id' => 2],
            ['name' => 'Jeniang', 'state_id' => 2],
            ['name' => 'Mergong', 'state_id' => 2],
            ['name' => 'Tanjung Dawai', 'state_id' => 2],

            // Kelantan cities
            ['name' => 'Kota Bharu', 'state_id' => 3],
            ['name' => 'Tumpat', 'state_id' => 3],
            ['name' => 'Kuala Krai', 'state_id' => 3],
            ['name' => 'Machang', 'state_id' => 3],
            ['name' => 'Tanah Merah', 'state_id' => 3],
            ['name' => 'Pasir Mas', 'state_id' => 3],
            ['name' => 'Bachok', 'state_id' => 3],
            ['name' => 'Ketereh', 'state_id' => 3],
            ['name' => 'Pengkalan Chepa', 'state_id' => 3],
            ['name' => 'Kota Tinggi', 'state_id' => 3],
            ['name' => 'Pasir Puteh', 'state_id' => 3],
            ['name' => 'Jeli', 'state_id' => 3],
            ['name' => 'Gua Musang', 'state_id' => 3],
            ['name' => 'Dabong', 'state_id' => 3],
            ['name' => 'Rantau Panjang', 'state_id' => 3],
            ['name' => 'Wakaf Bharu', 'state_id' => 3],
            ['name' => 'Bunut Payong', 'state_id' => 3],
            ['name' => 'Cherang Ruku', 'state_id' => 3],
            ['name' => 'Selising', 'state_id' => 3],
            ['name' => 'Limbachah', 'state_id' => 3],
            ['name' => 'Pahi', 'state_id' => 3],

            // Melaka cities
            ['name' => 'Malacca City', 'state_id' => 4],
            ['name' => 'Alor Gajah', 'state_id' => 4],
            ['name' => 'Jasin', 'state_id' => 4],
            ['name' => 'Masjid Tanah', 'state_id' => 4],
            ['name' => 'Merlimau', 'state_id' => 4],
            ['name' => 'Selandar', 'state_id' => 4],
            ['name' => 'Jelebu', 'state_id' => 4],
            ['name' => 'Ayer Keroh', 'state_id' => 4],
            ['name' => 'Bukit Beruang', 'state_id' => 4],
            ['name' => 'Durian Tunggal', 'state_id' => 4],
            ['name' => 'Tangkak', 'state_id' => 4],
            ['name' => 'Sungai Rambai', 'state_id' => 4],
            ['name' => 'Sungai Udang', 'state_id' => 4],
            ['name' => 'Batu Berendam', 'state_id' => 4],
            ['name' => 'Krubong', 'state_id' => 4],

            // Negeri Sembilan cities
            ['name' => 'Seremban', 'state_id' => 5],
            ['name' => 'Port Dickson', 'state_id' => 5],
            ['name' => 'Nilai', 'state_id' => 5],
            ['name' => 'Mantin', 'state_id' => 5],
            ['name' => 'Rantau', 'state_id' => 5],
            ['name' => 'Rembau', 'state_id' => 5],
            ['name' => 'Tampin', 'state_id' => 5],
            ['name' => 'Gemencheh', 'state_id' => 5],
            ['name' => 'Bahau', 'state_id' => 5],
            ['name' => 'Juasseh', 'state_id' => 5],
            ['name' => 'Jempol', 'state_id' => 5],
            ['name' => 'Jelebu', 'state_id' => 5],
            ['name' => 'Kuala Pilah', 'state_id' => 5],
            ['name' => 'Senawang', 'state_id' => 5],
            ['name' => 'Mambau', 'state_id' => 5],
            ['name' => 'Rasah', 'state_id' => 5],
            ['name' => 'Ampangan', 'state_id' => 5],

            // Pahang cities
            ['name' => 'Kuantan', 'state_id' => 6],
            ['name' => 'Pekan', 'state_id' => 6],
            ['name' => 'Temerloh', 'state_id' => 6],
            ['name' => 'Bentong', 'state_id' => 6],
            ['name' => 'Mentakab', 'state_id' => 6],
            ['name' => 'Lipis', 'state_id' => 6],
            ['name' => 'Raub', 'state_id' => 6],
            ['name' => 'Jerantut', 'state_id' => 6],
            ['name' => 'Maran', 'state_id' => 6],
            ['name' => 'Kuala Lipis', 'state_id' => 6],
            ['name' => 'Maran', 'state_id' => 6],
            ['name' => 'Chenor', 'state_id' => 6],
            ['name' => 'Bera', 'state_id' => 6],
            ['name' => 'Rompin', 'state_id' => 6],
            ['name' => 'Muadzam Shah', 'state_id' => 6],
            ['name' => 'Gambang', 'state_id' => 6],
            ['name' => 'Sungai Lembing', 'state_id' => 6],
            ['name' => 'Bandar Tun Abdul Razak', 'state_id' => 6],

            // Penang cities
            ['name' => 'George Town', 'state_id' => 7],
            ['name' => 'Butterworth', 'state_id' => 7],
            ['name' => 'Bukit Mertajam', 'state_id' => 7],
            ['name' => 'Seberang Jaya', 'state_id' => 7],
            ['name' => 'Seberang Perai', 'state_id' => 7],
            ['name' => 'Tanjong Tokong', 'state_id' => 7],
            ['name' => 'Tanjong Bungah', 'state_id' => 7],
            ['name' => 'Batu Ferringhi', 'state_id' => 7],
            ['name' => 'Teluk Bahang', 'state_id' => 7],
            ['name' => 'Balik Pulau', 'state_id' => 7],
            ['name' => 'Gelugor', 'state_id' => 7],
            ['name' => 'Jelutong', 'state_id' => 7],
            ['name' => 'Bayan Lepas', 'state_id' => 7],
            ['name' => 'Bayan Baru', 'state_id' => 7],
            ['name' => 'Sungai Ara', 'state_id' => 7],

            // Perak cities
            ['name' => 'Ipoh', 'state_id' => 8],
            ['name' => 'Taiping', 'state_id' => 8],
            ['name' => 'Teluk Intan', 'state_id' => 8],
            ['name' => 'Lumut', 'state_id' => 8],
            ['name' => 'Sitiawan', 'state_id' => 8],
            ['name' => 'Kampar', 'state_id' => 8],
            ['name' => 'Tapah', 'state_id' => 8],
            ['name' => 'Bidor', 'state_id' => 8],
            ['name' => 'Parit Buntar', 'state_id' => 8],
            ['name' => 'Kuala Kangsar', 'state_id' => 8],
            ['name' => 'Gerik', 'state_id' => 8],
            ['name' => 'Lenggong', 'state_id' => 8],
            ['name' => 'Pantai Remis', 'state_id' => 8],
            ['name' => 'Beruas', 'state_id' => 8],
            ['name' => 'Selama', 'state_id' => 8],

            // Perlis cities
            ['name' => 'Kangar', 'state_id' => 9],
            ['name' => 'Arau', 'state_id' => 9],
            ['name' => 'Kuala Perlis', 'state_id' => 9],
            ['name' => 'Simpang Empat', 'state_id' => 9],
            ['name' => 'Chuping', 'state_id' => 9],
            ['name' => 'Mata Ayer', 'state_id' => 9],
            ['name' => 'Beseri', 'state_id' => 9],
            ['name' => 'Kaki Bukit', 'state_id' => 9],
            ['name' => 'Padang Besar', 'state_id' => 9],
            ['name' => 'Wang Kelian', 'state_id' => 9],

            // Sabah cities
            ['name' => 'Kota Kinabalu', 'state_id' => 10],
            ['name' => 'Penampang', 'state_id' => 10],
            ['name' => 'Papar', 'state_id' => 10],
            ['name' => 'Beaufort', 'state_id' => 10],
            ['name' => 'Sipitang', 'state_id' => 10],
            ['name' => 'Kuala Penyu', 'state_id' => 10],
            ['name' => 'Membakut', 'state_id' => 10],
            ['name' => 'Tenom', 'state_id' => 10],
            ['name' => 'Nabawan', 'state_id' => 10],
            ['name' => 'Keningau', 'state_id' => 10],
            ['name' => 'Tambunan', 'state_id' => 10],
            ['name' => 'Ranau', 'state_id' => 10],
            ['name' => 'Kota Belud', 'state_id' => 10],
            ['name' => 'Tuaran', 'state_id' => 10],
            ['name' => 'Tamparuli', 'state_id' => 10],
            ['name' => 'Kiulu', 'state_id' => 10],
            ['name' => 'Sandakan', 'state_id' => 10],
            ['name' => 'Beluran', 'state_id' => 10],
            ['name' => 'Telupid', 'state_id' => 10],
            ['name' => 'Kinabatangan', 'state_id' => 10],
            ['name' => 'Tongod', 'state_id' => 10],
            ['name' => 'Lahad Datu', 'state_id' => 10],
            ['name' => 'Kunak', 'state_id' => 10],
            ['name' => 'Semporna', 'state_id' => 10],
            ['name' => 'Kudat', 'state_id' => 10],

            // Sarawak cities
            ['name' => 'Kuching', 'state_id' => 11],
            ['name' => 'Bau', 'state_id' => 11],
            ['name' => 'Lundu', 'state_id' => 11],
            ['name' => 'Samarahan', 'state_id' => 11],
            ['name' => 'Asajaya', 'state_id' => 11],
            ['name' => 'Serian', 'state_id' => 11],
            ['name' => 'Simunjan', 'state_id' => 11],
            ['name' => 'Mukah', 'state_id' => 11],
            ['name' => 'Dalat', 'state_id' => 11],
            ['name' => 'Matu', 'state_id' => 11],
            ['name' => 'Daro', 'state_id' => 11],
            ['name' => 'Sibu', 'state_id' => 11],
            ['name' => 'Kanowit', 'state_id' => 11],
            ['name' => 'Selangau', 'state_id' => 11],
            ['name' => 'Julau', 'state_id' => 11],
            ['name' => 'Sarikei', 'state_id' => 11],
            ['name' => 'Meradong', 'state_id' => 11],
            ['name' => 'Bintulu', 'state_id' => 11],
            ['name' => 'Tatau', 'state_id' => 11],
            ['name' => 'Sebauh', 'state_id' => 11],
            ['name' => 'Niah', 'state_id' => 11],
            ['name' => 'Miri', 'state_id' => 11],
            ['name' => 'Subis', 'state_id' => 11],
            ['name' => 'Marudi', 'state_id' => 11],
            ['name' => 'Telang Usan', 'state_id' => 11],
            ['name' => 'Limbang', 'state_id' => 11],
            ['name' => 'Lawas', 'state_id' => 11],
            ['name' => 'Sundar', 'state_id' => 11],
            ['name' => 'Belaga', 'state_id' => 11],
            ['name' => 'Kapit', 'state_id' => 11],
            ['name' => 'Song', 'state_id' => 11],
            ['name' => 'Sri Aman', 'state_id' => 11],

            // Selangor cities
            ['name' => 'Sabak Bernam', 'state_id' => 12],
            ['name' => 'Sungai Besar', 'state_id' => 12],
            ['name' => 'Hulu Selangor', 'state_id' => 12],
            ['name' => 'Tanjong Karang', 'state_id' => 12],
            ['name' => 'Kuala Selangor', 'state_id' => 12],
            ['name' => 'Selayang', 'state_id' => 12],
            ['name' => 'Gombak', 'state_id' => 12],
            ['name' => 'Ampang', 'state_id' => 12],
            ['name' => 'Pandan', 'state_id' => 12],
            ['name' => 'Hulu Langat', 'state_id' => 12],
            ['name' => 'Serdang', 'state_id' => 12],
            ['name' => 'Puchong', 'state_id' => 12],
            ['name' => 'Kelana Jaya', 'state_id' => 12],
            ['name' => 'Petaling Jaya', 'state_id' => 12],
            ['name' => 'Subang', 'state_id' => 12],
            ['name' => 'Shah Alam', 'state_id' => 12],
            ['name' => 'Kapar', 'state_id' => 12],
            ['name' => 'Klang', 'state_id' => 12],
            ['name' => 'Kota Raja', 'state_id' => 12],
            ['name' => 'Kuala Langat', 'state_id' => 12],
            ['name' => 'Sepang', 'state_id' => 12],

            // Terengganu cities
            ['name' => 'Kuala Terengganu', 'state_id' => 13],
            ['name' => 'Kemaman', 'state_id' => 13],
            ['name' => 'Dungun', 'state_id' => 13],
            ['name' => 'Marang', 'state_id' => 13],
            ['name' => 'Hulu Terengganu', 'state_id' => 13],
            ['name' => 'Setiu', 'state_id' => 13],
            ['name' => 'Besut', 'state_id' => 13],

            // Kuala Lumpur cities
            ['name' => 'Kuala Lumpur', 'state_id' => 14],

            // Labuan cities
            ['name' => 'Labuan', 'state_id' => 15],

            // Putrajaya cities
            ['name' => 'Putrajaya', 'state_id' => 16],
            ['name' => 'other', 'state_id' => 999]
        ];

        foreach ($cities as $city){
            City::create($city);
        }
    }
}
