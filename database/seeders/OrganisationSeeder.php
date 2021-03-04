<?php

namespace Database\Seeders;

use App\Models\Organisation;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(Organisation::class)->create([
            'name' => 'moers festival',
            'description' => 'Das mœrs festival ist ein international beachtetes Groß-Event der aktuellen improvisierten Musik. Es findet jeweils an Pfingsten statt und steht für Risikobereitschaft und den Mut zu Neuem. Es ist damit Garant für musikalische Entdeckungen jenseits des Mainstream. Abenteuerlust und Grenzüberschreitungen prägen das Festival, und dass dabei die musikalischen Ränder weit auseinander liegen ist erklärte Absicht.',
            'logo_url' => 'https://www.moers-festival.de/fileadmin/img/logo-quer_md.gif'
        ]);

        factory(Organisation::class)->create([
            'name' => 'Code for Niederrhein',
            'description' => 'Denken, designen, programmieren, mitreden, weitersagen! Gefragt sind Spaß am kreativen Denken und das Interesse an offenen Daten.',
            'logo_url' => 'https://www.codeforniederrhein.de/wp-content/uploads/2017/01/cfn_logo_521.png'
        ]);

        factory(Organisation::class)->create([
            'name' => 'Gymnasium Adolfinum',
            'description' => 'Aus Tradition – innovativ.',
            'logo_url' => 'https://www.uni-due.de/imperia/md/content/konfuzius-institut/2015/fittosize__1200_0_8690bc42f1a0ee224ff7854f749291af_logo_adolfinum.jpeg'
        ]);

    }
}
