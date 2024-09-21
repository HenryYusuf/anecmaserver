<?php

namespace App\Lib;

class RandomImage
{
    public function getImage()
    {
        $images = [
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313453/Dampak_1_y5m3iz.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313454/Dampak_2_knniqs.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313454/Dampak_3_wbtj1b.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313454/Dampak_4_y75ftj.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313455/Dampak_5_ulojew.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313457/Dampak_6_uj9aot.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313457/Dampak_7_sbdld6.jpg',

            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313439/gejala_1_lfndqd.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313438/Gejala_2_c1jrm0.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313438/Gejala_3_o6xqzb.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313439/Gejala_4_ajosjn.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313439/Gejala_5_nbdteb.jpg',

            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313376/Gizi_1_pnvcef.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313377/Gizi_2_b8azqh.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313378/Gizi_3_xlmlfq.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313376/Gizi_4_a8l7g5.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313376/Gizi_5_psa7am.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313376/Gizi_6_mrkygo.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313376/Gizi_7_nlqput.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313377/Gizi_8_zyczjr.jpg',
            'https://res.cloudinary.com/dm7uiyhez/image/upload/v1726313377/Gizi_9_twng75.jpg'
        ];

        $randomImage = $images[array_rand($images)];

        return $randomImage;
    }
}
