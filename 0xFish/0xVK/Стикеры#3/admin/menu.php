<? if(!isset($_SESSION['admin'])) { 
echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=/admin/auth.php">';
}

echo '<li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                Меню
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Главная</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="export.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Экспорт текстом</p>
                </a>
              </li>
			  
			  <li class="nav-item">
                <a href="settings.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Настройки сайта</p>
                </a>
              </li>
			  			  <li class="nav-item">
                <a href="spamers.php" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Спамеры</p>
                </a>
              </li>
            </ul>
          </li>
		  '; ?>