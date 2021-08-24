public function getSite($arFilter=array("*"),$arSelect=array("*"),$arSort=array("ID"=>"ASC"),$pageParams = false){

		// if(self::$siteList != NULL) return self::$siteList;

		if(empty(self::siteHL)) return false;
		$this->HLload(self::siteHL);
		$arResult = false;
	    $obCache = new CPHPCache;
        $life_time = 3600;
        $cache_params = $arFilter;
        $cache_params['func']='getSite';
        $cache_params['arSelect']=$arSelect;
        $cache_params['sort']=$arSort;
        $cache_params['pageParams']=$pageParams;
        $cache_id = md5(serialize($cache_params));
        if($obCache->InitCache($life_time, $cache_id, "/")) :
            $arResult = $obCache->GetVars();
        else :
	        $res = $this->strEntityDataClass::getList(array(
	            'select' => $arSelect,
	         	'order'  => $arSort,
	         	'filter' => $arFilter
	        ));

		    while ($arItem = $res->fetch()) {
		        $arResult[$arItem['ID']] = $arItem;
		    }
        endif;
 
        if($obCache->StartDataCache()):
            $obCache->EndDataCache($arResult);
        endif;

		return self::$siteList = $arResult;

	}
