<form class="filter-form module" action="" method="post">
  <fieldset class="filter-field">
    <div class="field-title"> <a href="javascript:void(0)">Поиск игр</a> </div>
    <div class="field-container">
        <input type="hidden" name="do" value="search">
        <input type="hidden" name="subaction" value="search">
        <input class="game-search-input" type="search" name="story" onChange="$('.filter-form').submit()" required="" autocomplete="off">
    </div>
  </fieldset>
  <fieldset class="filter-field">
    <div class="field-title"> <a href="javascript:void(0)">Метки</a> </div>
    <div class="field-container" id="mark">
      <div class="customSelect filter-select custom" id="select-markSelect">
        <select id="markSelect" class="filter-select custom">
          <option>Поиск по метке</option>
          {tags}
        </select>
      </div>
    </div>
  </fieldset>
  <fieldset class="filter-field">
    <div class="field-title"> <a href="javascript:void(0)">Цена</a> </div>
    <div class="field-container">
      <ul class="price-range-list">
        <li class="price-from-item">
          <input type="text" id="price-range-min-price" onChange="filter()" placeholder="0">
        </li>
        <li class="price-to-item">
          <input type="text" id="price-range-max-price" onChange="filter()" placeholder="9999">
        </li>
      </ul>
    </div>
  </fieldset>
  <fieldset class="filter-field">
    <div class="field-title"> <a href="javascript:void(0)">Активация</a> </div>
    <div class="field-container">
      <ul class="filter-checkbox-list col2" data-filter="activation">
        <li class="item" id="mlt-Battle__net">
          <input data-data="Battle__net" id="activation-checkbox01" onChange="filter()"  class="checkbox-input" type="checkbox">
          <label for="activation-checkbox01" class="checkbox-label activation-icon01">Battle.net</label>
        </li>
        <li class="item" id="mlt-Origin">
          <input data-data="Origin" id="activation-checkbox02" onChange="filter()"  class="checkbox-input" type="checkbox">
          <label for="activation-checkbox02" class="checkbox-label activation-icon03">Origin</label>
        </li>
        <li class="item" id="mlt-PSN">
          <input data-data="PSN" id="activation-checkbox03" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="activation-checkbox03" class="checkbox-label activation-icon05">PSN</label>
        </li>
        <li class="item" id="mlt-Steam">
          <input data-data="Steam" id="activation-checkbox04" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="activation-checkbox04" class="checkbox-label activation-icon02">Steam</label>
        </li>
        <li class="item" id="mlt-Uplay">
          <input data-data="Uplay" id="activation-checkbox05" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="activation-checkbox05" class="checkbox-label activation-icon04">Uplay</label>
        </li>
        <li class="item" id="mlt-Xbox">
          <input data-data="Xbox" id="activation-checkbox06" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="activation-checkbox06" class="checkbox-label activation-icon06">Xbox</label>
        </li>
        <li class="item" id="mlt-other">
          <input data-data="other" id="activation-checkbox07" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="activation-checkbox07" class="checkbox-label ">Другой</label>
        </li>
      </ul>
      <!--a class="show-more-link" href="javascript:void(0)">Показать больше</a--> 
    </div>
  </fieldset>
  <fieldset class="filter-field">
    <div class="field-title"> <a href="javascript:void(0)">Категория</a> </div>
    <div class="field-container">
      <ul class="filter-checkbox-list col2" data-filter="categories">
        <li class="item" id="mlt-games">
          <input data-data="Игры" id="category-checkbox01" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="category-checkbox01" class="checkbox-label">Игры</label>
        </li>
        <li class="item" id="mlt-collection">
          <input data-data="Сборник" id="category-checkbox02" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="category-checkbox02" class="checkbox-label">Сборник</label>
        </li>
        <li class="item" id="mlt-dlc">
          <input data-data="Дополнения" id="category-checkbox03" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="category-checkbox03" class="checkbox-label">Дополнения</label>
        </li>
        <li class="item" id="mlt-programs">
          <input data-data="Программы" id="category-checkbox05" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="category-checkbox05" class="checkbox-label">Программы</label>
      </ul>
    </div>
  </fieldset>
  <fieldset class="filter-field">
    <div class="field-title"> <a href="javascript:void(0)">Доступность</a> </div>
    <div class="field-container">
      <ul class="filter-checkbox-list col2" data-filter="avail">
        <li class="item" id="mlt-released">
          <input data-data="Игра вышла" id="availability-checkbox01" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="availability-checkbox01" class="checkbox-label">Игра вышла</label>
        </li>
        <li class="item" id="mlt-preorder">
          <input data-data="Предзаказ" id="availability-checkbox05" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="availability-checkbox05" class="checkbox-label">Предзаказ</label>
        </li>
        <li class="item" id="mlt-early">
          <input data-data="Ранний доступ" id="availability-checkbox02" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="availability-checkbox02" class="checkbox-label">Ранний доступ</label>
      </ul>
    </div>
  </fieldset>
  <fieldset class="filter-field">
    <div class="field-title"> <a href="javascript:void(0)">Жанры</a> </div>
    <div class="field-container">
      <ul class="filter-checkbox-list col2" data-filter="genres">
        <li class="item" id="mlt-action">
          <input data-data="Экшен" id="genre-checkbox01" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="genre-checkbox01" class="checkbox-label">Экшен</label>
        </li>
        <li class="item" id="mlt-adventure">
          <input data-data="Приключения" id="genre-checkbox03" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="genre-checkbox03" class="checkbox-label">Приключения</label>
        </li>
        <li class="item" id="mlt-strategy">
          <input data-data="Стратегии" id="genre-checkbox04" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="genre-checkbox04" class="checkbox-label">Стратегии</label>
        </li>
        <li class="item" id="mlt-rpg">
          <input data-data="Ролевые" id="genre-checkbox05" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="genre-checkbox05" class="checkbox-label">Ролевые</label>
        </li>
        <li class="item" id="mlt-simulator">
          <input data-data="Симуляторы" id="genre-checkbox06" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="genre-checkbox06" class="checkbox-label">Симуляторы</label>
        </li>
        <li class="item" id="mlt-logic">
          <input data-data="Казуальные" id="genre-checkbox07" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="genre-checkbox07" class="checkbox-label">Казуальные</label>
        </li>
        <li class="item" id="mlt-racing">
          <input data-data="Гонки" id="genre-checkbox08" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="genre-checkbox08" class="checkbox-label">Гонки</label>
        </li>
        <li class="item" id="mlt-sport">
          <input data-data="Спорт" id="genre-checkbox09" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="genre-checkbox09" class="checkbox-label">Спорт</label>
        </li>
        <li class="item" id="mlt-online">
          <input data-data="Онлайн" id="genre-checkbox010" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="genre-checkbox010" class="checkbox-label">Онлайн</label>
        </li>
        <li class="item" id="mlt-fighting">
          <input data-data="Файтинги" id="genre-checkbox011" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="genre-checkbox011" class="checkbox-label">Файтинги</label>
        </li>
      </ul>
    </div>
  </fieldset>
  <fieldset class="filter-field">
    <div class="field-title"> <a href="javascript:void(0)">Дата выхода, год.</a> </div>
    <div class="field-container">
      <ul class="year-range-list">
        <li class="year-from-item">
          <div class="customSelect filter-select custom" id="select-fromDateSelect">
            <select id="fromDateSelect" onChange="filter()" class="filter-select custom">
              <option selected="selected">1985</option>
              <option>1986</option>
              <option>1987</option>
              <option>1988</option>
              <option>1989</option>
              <option>1990</option>
              <option>1991</option>
              <option>1992</option>
              <option>1993</option>
              <option>1994</option>
              <option>1995</option>
              <option>1996</option>
              <option>1997</option>
              <option>1998</option>
              <option>1999</option>
              <option>2000</option>
              <option>2001</option>
              <option>2002</option>
              <option>2003</option>
              <option>2004</option>
              <option>2005</option>
              <option>2006</option>
              <option>2007</option>
              <option>2008</option>
              <option>2009</option>
              <option>2010</option>
              <option>2011</option>
              <option>2012</option>
              <option>2013</option>
              <option>2014</option>
              <option>2015</option>
              <option>2016</option>
              <option>2017</option>
              <option>2018</option>
            </select>
          </div>
        </li>
        <li class="year-to-item">
          <div class="customSelect filter-select custom" id="select-toDateSelect">
            <select id="toDateSelect" onChange="filter()" class="filter-select custom">
              <option selected="selected">2018</option>
              <option>2017</option>
              <option>2016</option>
              <option>2015</option>
              <option>2014</option>
              <option>2013</option>
              <option>2012</option>
              <option>2011</option>
              <option>2010</option>
              <option>2009</option>
              <option>2008</option>
              <option>2007</option>
              <option>2006</option>
              <option>2005</option>
              <option>2004</option>
              <option>2003</option>
              <option>2002</option>
              <option>2001</option>
              <option>2000</option>
              <option>1999</option>
              <option>1998</option>
              <option>1997</option>
              <option>1996</option>
              <option>1995</option>
              <option>1994</option>
              <option>1993</option>
              <option>1992</option>
              <option>1991</option>
              <option>1990</option>
              <option>1989</option>
              <option>1988</option>
              <option>1987</option>
              <option>1986</option>
              <option>1985</option>
            </select>
          </div>
        </li>
      </ul>
    </div>
  </fieldset>
  <fieldset class="filter-field">
    <div class="field-title"> <a href="javascript:void(0)">Издатель</a> </div>
    <div class="field-container" id="publisher">
      <div class="customSelect filter-select custom" id="select-izdatelSelect">
        <select id="izdatelSelect" class="filter-select custom"  onChange="filter()">
          <option>Не важно</option>
          <option>1C Company</option>
          <option>1C-777</option>
          <option>1C-SoftClub</option>
          <option>1C-СофтКлаб</option>
          <option>1С-СофтКлаб</option>
          <option>2D BOY</option>
          <option>2K Games</option>
          <option>2K Sports</option>
          <option>505 Games</option>
          <option>800 North and Digital Ranch</option>
          <option>ACE Team</option>
          <option>Ackk Studios</option>
          <option>Activision</option>
          <option>Agharta Studio</option>
          <option>Alastair John Jack</option>
          <option>Aleksey Abramenko</option>
          <option>Alien Shooter</option>
          <option>Alientrap Games Inc</option>
          <option>AlwaysGeeky Games</option>
          <option>Amanita Design</option>
          <option>Angry Mob Games</option>
          <option>Arachnid Games</option>
          <option>Arcen Games</option>
          <option>Arcen Games, LLC</option>
          <option>Artifex Mundi sp. z o.o.</option>
          <option>Artifice Studio</option>
          <option>ATLUS</option>
          <option>Axis Game Factory</option>
          <option>Bandai Namco Games</option>
          <option>Battlegoat Studios</option>
          <option>Beatnik Games</option>
          <option>Benjamin Rivers</option>
          <option>Bethesda Softworks</option>
          <option>Big Sandwich Games</option>
          <option>BigSims.com</option>
          <option>Bitbox S.L.</option>
          <option>bitComposer Games</option>
          <option>bitSmith Games</option>
          <option>Black Market Games</option>
          <option>Black Pants Studio</option>
          <option>Blazing Griffin Ltd.</option>
          <option>Blind Mind Studios</option>
          <option>Blizzard Entertaiment</option>
          <option>Blizzard Entertainment</option>
          <option>Bohemia Interactive</option>
          <option>Bossa Studios</option>
          <option>Brawsome</option>
          <option>Broken Rules</option>
          <option>Buka Entertainment</option>
          <option>Capcom</option>
          <option>CCP Games</option>
          <option>CD Projekt RED</option>
          <option>Chaosoft Games</option>
          <option>CI Games</option>
          <option>CINEMAX, s.r.o.</option>
          <option>City Interactive</option>
          <option>Cliffhanger Productions</option>
          <option>Codemasters</option>
          <option>Coffee Stain Studios</option>
          <option>Cosmi</option>
          <option>Crescent Moon Games</option>
          <option>Croteam</option>
          <option>Daedalic Entertainment</option>
          <option>Dark Energy Digital Ltd.</option>
          <option>Dark Vale Games LLC</option>
          <option>DarkGod</option>
          <option>Dead Mage</option>
          <option>Deep Silver</option>
          <option>Degica</option>
          <option>Devolver Digital</option>
          <option>Devolver Digital and Croteam</option>
          <option>Digerati Distribution</option>
          <option>Digital Eel</option>
          <option>Digital Extremes</option>
          <option>Digital Tribe</option>
          <option>Dischan Media</option>
          <option>DnS Development</option>
          <option>Doppler Interactive</option>
          <option>Double Eleven</option>
          <option>Double Fine Productions</option>
          <option>EA Sports</option>
          <option>Eden Games</option>
          <option>Eden Studios</option>
          <option>Eidos Entertainment</option>
          <option>Eidos Interactive</option>
          <option>eigoMANGA</option>
          <option>Electronic Arts</option>
          <option>Encore, Viva Media</option>
          <option>Endless Loop Studios</option>
          <option>Enlight Entertainment Europe Ltd.</option>
          <option>Epic Games, Inc.</option>
          <option>Evolved Games</option>
          <option>Exor Studios</option>
          <option>Exosyphen studios</option>
          <option>Firebrand Games</option>
          <option>Focus Home Interactive</option>
          <option>Forever Entertainment S. A.</option>
          <option>Freebird Games</option>
          <option>Frictional Games</option>
          <option>Frontier</option>
          <option>Frozenbyte</option>
          <option>Futuremark</option>
          <option>Gaijin Entertainment</option>
          <option>Galactic Cafe</option>
          <option>Game Factory Interactive</option>
          <option>Giant Army</option>
          <option>Goodhustle Studios</option>
          <option>GSC Game World</option>
          <option>GSC World Publishing</option>
          <option>Hammerpoint Interactive</option>
          <option>Hashbang Games</option>
          <option>Hassey Enterprises, Inc.</option>
          <option>HD Publishing</option>
          <option>Headup Games</option>
          <option>HeroCraft, Ltd.</option>
          <option>Hörberg Productions</option>
          <option>Human Head Studios</option>
          <option>Iceberg Interactive</option>
          <option>id Software</option>
          <option>Immanitas Entertainment</option>
          <option>increpare games</option>
          <option>IndiePub</option>
          <option>Instinct Software Ltd.</option>
          <option>Interplay Inc.</option>
          <option>Introversion Software</option>
          <option>Iocaine Studios</option>
          <option>ISOTX</option>
          <option>Jagex</option>
          <option>Kalypso Media Digital</option>
          <option>KinifiGames LLC</option>
          <option>KISS ltd</option>
          <option>Klei Entertainment</option>
          <option>Konami Digital Entertainment</option>
          <option>KranX Productions</option>
          <option>Kreatoriet AB</option>
          <option>Krystian Majewski</option>
          <option>Lace Mamba Digital</option>
          <option>Larian Studios</option>
          <option>Legacy Games</option>
          <option>Libredia</option>
          <option>Lonely Troops</option>
          <option>LucasArts</option>
          <option>Lucky Frame</option>
          <option>Ludochip</option>
          <option>LudoCraft Ltd.</option>
          <option>Lupus Studios</option>
          <option>Makivision Games</option>
          <option>Matthew Brown</option>
          <option>Matthew C Cohen</option>
          <option>Merge Games</option>
          <option>Meridian4</option>
          <option>Microsoft</option>
          <option>Microsoft Games Studios</option>
          <option>Microsoft Studios</option>
          <option>Midnight City</option>
          <option>Might and Delight</option>
          <option>Mighty Rabbit Studios</option>
          <option>Mike Bithell</option>
          <option>Milkstone Studios</option>
          <option>MinMax Games Ltd.</option>
          <option>Misfits Attic</option>
          <option>Mojang AB</option>
          <option>MumboJumbo</option>
          <option>Muse Games</option>
          <option>Mystic Box</option>
          <option>N3V Games</option>
          <option>NAMCO</option>
          <option>Namco Bandai Games</option>
          <option>NCsoft</option>
          <option>ND Games</option>
          <option>Neko Entertainment</option>
          <option>Nemesys Games</option>
          <option>Nemoria Entertainment</option>
          <option>NeocoreGames</option>
          <option>Nicolas Games</option>
          <option>Night Dive Studios</option>
          <option>Nimbly Games</option>
          <option>Nival</option>
          <option>Nordic Games</option>
          <option>Oovee® Game Studios</option>
          <option>OP Productions</option>
          <option>ORiGO GAMES</option>
          <option>Owlchemy Labs</option>
          <option>Panic Art Studios</option>
          <option>Pantera Entertainment</option>
          <option>Paradox Interactive</option>
          <option>Party of Sin</option>
          <option>Petroglyph</option>
          <option>Phoenix Online Studios</option>
          <option>Phr00t's Software</option>
          <option>Playdead</option>
          <option>Playrix Entertainment</option>
          <option>Playway</option>
          <option>PlayWay S.A.</option>
          <option>Plug In Digital</option>
          <option>Plug In Digital, Bigben Interactive</option>
          <option>PomPom Games</option>
          <option>PopCap Games, Inc.</option>
          <option>Positech</option>
          <option>Rake in Grass</option>
          <option>Ranmantaru Games</option>
          <option>Re-Logic</option>
          <option>Rebellion</option>
          <option>Recoil Games</option>
          <option>Red Barrels</option>
          <option>Relentless Software</option>
          <option>Remedy Entertainment</option>
          <option>Replay Games, Inc</option>
          <option>Reptile Games</option>
          <option>Reverb Publishing</option>
          <option>Reverie World Studios, INC</option>
          <option>Revolution Software Ltd</option>
          <option>Ripstone</option>
          <option>Rising Star Games</option>
          <option>Robot Entertainment</option>
          <option>Rocket Jump</option>
          <option>Rockstar Games</option>
          <option>Rockstar Games&nbsp;</option>
          <option>Roman Syrovatka</option>
          <option>Rondomedia Marketing &amp; Vertriebs GmbH</option>
          <option>Ronimo Games</option>
          <option>Rovio Entertainment Ltd</option>
          <option>RuneStorm</option>
          <option>Running With Scissors</option>
          <option>Saibot Studios</option>
          <option>Sakari Indie</option>
          <option>SCEE</option>
          <option>Screen 7</option>
          <option>SCS Software</option>
          <option>Seaven Studio</option>
          <option>SEGA</option>
          <option>Semanoor</option>
          <option>SGS Software</option>
          <option>ShadowShifters</option>
          <option>Shorebound Studios</option>
          <option>Shovsoft</option>
          <option>Sigma Team Inc.</option>
          <option>Silver Dollar Games</option>
          <option>SimBin</option>
          <option>Simos Mediacom</option>
          <option>Size Five Games</option>
          <option>Skygoblin</option>
          <option>Smudged Cat Games Ltd</option>
          <option>Sony</option>
          <option>Sony Online Entertainment</option>
          <option>Sos Mikolaj Kaminski</option>
          <option>South East Games</option>
          <option>SouthPeak Games</option>
          <option>Spicyhorse Games</option>
          <option>SQUARE ENIX</option>
          <option>SQUARE ENIX, Eidos Interactive</option>
          <option>Stainless Games Ltd</option>
          <option>Stardock Entertainment</option>
          <option>State of Play Games</option>
          <option>Stickmen Studios</option>
          <option>Strategy First</option>
          <option>Subset Games</option>
          <option>Sumom Games</option>
          <option>SuperVillain Studios</option>
          <option>Team Meat</option>
          <option>Techland</option>
          <option>Telltale Games</option>
          <option>Teotl Studios</option>
          <option>The Behemoth</option>
          <option>The Binary Mill</option>
          <option>Thechineseroom</option>
          <option>THQ</option>
          <option>Three Gates</option>
          <option>tinyBuild</option>
          <option>Tomorrow Corporation</option>
          <option>Topware Interactive</option>
          <option>Torn Banner Studios</option>
          <option>Transhuman</option>
          <option>Trapdoor</option>
          <option>Trion Worlds</option>
          <option>Triple.B.Titles</option>
          <option>Tripwire Interactive</option>
          <option>Uber Entertainment</option>
          <option>Ubisoft</option>
          <option>UIE GmbH</option>
          <option>Unbound Creations LLC</option>
          <option>Unigine Corp.</option>
          <option>United Independent</option>
          <option>Unknown Worlds Entertainment</option>
          <option>Vae Victis Games</option>
          <option>Valve</option>
          <option>Viva Media Inc</option>
          <option>Wales Interactive</option>
          <option>Warner Bros. IE</option>
          <option>Warner Bros. IE&nbsp;&nbsp;</option>
          <option>WB Games</option>
          <option>White Giant RPG Studios</option>
          <option>WXP Games, LLC</option>
          <option>XeniosVision</option>
          <option>Zachtronics Industries</option>
          <option>Zaxis Games</option>
          <option>Zero Point Software</option>
          <option>Zooloretto</option>
          <option>Акелла</option>
          <option>Бука</option>
          <option>Новый Диск</option>
          <option>Уточняется</option>
        </select>
      </div>
    </div>
  </fieldset>
  <fieldset class="filter-field">
    <div class="field-title"> <a href="javascript:void(0)">Язык</a> </div>
    <div class="field-container">
      <ul class="filter-checkbox-list" data-filter="language">
        <li class="item" id="mlt-ru">
          <input data-data="Русский" id="language-checkbox01" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="language-checkbox01" class="checkbox-label">Русский</label>
        </li>
        <li class="item" id="mlt-en">
          <input data-data="Английский" id="language-checkbox02" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="language-checkbox02" class="checkbox-label">Английский</label>
      </ul>
    </div>
  </fieldset>
  <fieldset class="filter-field">
    <div class="field-title"> <a href="javascript:void(0)">ОС</a> </div>
    <div class="field-container">
      <ul class="filter-checkbox-list" data-filter="platforms">
        <li class="item" id="mlt-windows">
          <input data-data="Windows" id="os-checkbox01" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="os-checkbox01" class="checkbox-label os-icon01">Windows</label>
        </li>
        <li class="item" id="mlt-mac">
          <input data-data="Mac OS X" id="os-checkbox02" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="os-checkbox02" class="checkbox-label os-icon02">Mac OS X</label>
        </li>
        <li class="item" id="mlt-linux">
          <input data-data="SteamOS + Linux" id="os-checkbox03" onChange="filter()" class="checkbox-input" type="checkbox">
          <label for="os-checkbox03" class="checkbox-label os-icon03">SteamOS + Linux</label>
        </li>
      </ul>
    </div>
  </fieldset>
  <div class="filter-footer"> <a class="filter-reset-btn" href="/catalogs">Сброс фильтра</a> </div>
</form>
