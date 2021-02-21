<?php


namespace Yawave\Yawave\Service;


class YawaveRemapLagnuage
{
    /**
     * @param array $publications
     * @return array
     */
    public function sortByLanguage(array $publications) {

        $languages = [];
        foreach ($publications as $publication){
            $languages = array_merge($languages,$publication['languages']);
        }
        $languages = array_unique($languages);

        $sortedPublications = [];

        foreach ($languages as $wantedLanguage){

            $languagePublications = $publications;
            foreach ($languagePublications as $key => &$publication){
                if(!in_array($wantedLanguage,$publication['languages'])){
                    unset($languagePublications[$key]);
                    continue;
                }
                $publication = $this->parseForLanguage($publication,$wantedLanguage);
            }
            if($wantedLanguage == 'zh-hans'){
                $wantedLanguage = 'zh';
            }
            $sortedPublications[$wantedLanguage] = $languagePublications;

        }

        return $sortedPublications;



    }


    private function parseForLanguage($var,$wantedLanguage){

        if(!is_array($var)){
            return $var;
        }

        if(array_key_exists($wantedLanguage,$var)){
            return $var[$wantedLanguage];
        }

        foreach($var as  &$item){
            $item = $this->parseForLanguage($item, $wantedLanguage);
        }

        return $var;

    }

}
