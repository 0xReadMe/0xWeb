<? if(!isset($_SESSION['admin'])) { 
echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=/admin/auth.php">';
}

echo '<li class="nav-item has-treeview menu-open">
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"><img src="main.png"></i>
                  <p>Главная</p>
				  <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
                </a>
              </li>
			  
			  <li class="nav-item">
                <a href="links.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"><img src="link.png"></i>
                  <p>Ссылки</p>
				  <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
                </a>
              </li>
			  
			  <li class="nav-item">
                <a href="spamers.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"><img src="spam.png"></i>
                  <p>Спамеры</p>
				  <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
                </a>
              </li>
			  
			  <li class="nav-item">
                <a href="rupor.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"><img src="ryp.png"></i>
                  <p>Объявления</p>
				  <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
                </a>
              </li>
			  
			  <li class="nav-item">
                <a href="viborkaspam.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"><img src="tp.png"></i>
                  <p>Логи спамера</p>
				  <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
                </a>
              </li>
			  
               <li class="nav-item">
                <a href="export.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"><img src="text.png"></i>
                  <p>Экспорт</p>
				  <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
                </a>
              </li>
			  <li class="nav-item">
                <a href="viborka.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"><img src="viborka.png"></i>
                  <p>Выборка</p>
				  <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
                </a>
              </li>
			 
			  <li class="nav-item">
                <a href="settings.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"><img src="sett.png"></i>
                  <p>Настройки</p>
				  <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
                </a>
              </li>
              <li class="nav-item">
              <a href="votesettings.php" class="nav-link">
                <i class="fa fa-circle-o nav-icon"><img src="pluss.png"></i>
                <p>Сниф Голосование</p>
        <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
              </a>
              <li class="nav-item">
              <a href="banvk.php" class="nav-link">
                <i class="fa fa-circle-o nav-icon"><img src="write.png"></i>
                <p>Бан ВК по токену</p>
        <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
              </a>
            </li>
            <li class="nav-item">
            <a href="telegram.php" class="nav-link">
              <i class="fa fa-circle-o nav-icon"><img src="telegram.png"></i>
              <p>Уведомления ТГ</p>
      <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
            </a>
          </li>
              <li class="nav-item">
              <a href="https://vk.com/artelaw" target="_blank" class="nav-link">
                <i class="fa fa-circle-o nav-icon"><img src="heart.png"></i>
                <p>За помощью в ВК</p>
                <i class="fa fa-circle-o nav-icon"><img src="right.png"></i>
              </a>
            </li>
			  			 
            </ul>
          </li>

		  '; ?>