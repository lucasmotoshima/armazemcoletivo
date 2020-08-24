<script type="text/javascript">
    $(document).ready( function() {
	});
	
    function alteraLido(id,elemento,viewName)
    {
        var iconAlerta                  = $('<img src="<?php echo base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        var iconConf                    = $('<img src="<?php echo base_url()?>public/images/icones/ico_confirmado.png" class="icon" />');
        var iconCarregando              = $('<img src="<?php echo base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
        var viewName                    = '<?php echo base_url("mensagem/alteraLido")?>';
        $('#msg').html(iconCarregando);
        jQuery.ajax({
        type: "POST",
        url: viewName,
        data:   {
                id:id
                },
        dataType: 'json',
        success: function(returnedData){
            if( returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
            {
                $('#msg_'+id).fadeOut(200);
                $('#status').html(iconConf);
                $('#status').append(returnedData.msg);
            }
            else
            {
                $('#status').html('');
                $('#status').html(iconAlerta);
                $('#status').append(returnedData.msg);
            }
            },
            async: true
        });
    }
    
    function excluir(id,elemento,viewName)
    {
        var iconAlerta                  = $('<img src="<?php echo base_url()?>public/images/icones/ico_alerta.png" class="icon" />');
        var iconConf                    = $('<img src="<?php echo base_url()?>public/images/icones/ico_confirmado.png" class="icon" />');
        var iconCarregando              = $('<img src="<?php echo base_url()?>public/images/icones/loading.gif" class="iconCarregando" />');
        var viewName                    = '<?php echo base_url("mensagem/delete")?>';
        $('#msg').html(iconCarregando);
        jQuery.ajax({
        type: "POST",
        url: viewName,
        data:   {
                id:id
                },
        dataType: 'json',
        success: function(returnedData){
            if( returnedData.error == null || returnedData.error == '' || !returnedData.error || returnedData.error == false)
            {
                $('#msg_'+id).fadeOut(200);
                $('#status').html(iconConf);
                $('#status').append(returnedData.msg);
            }
            else
            {
                $('#status').html('');
                $('#status').html(iconAlerta);
                $('#status').append(returnedData.msg);
            }
            },
            async: true
        });
    }
	
 </script>
        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  	<?$pos = strpos($this->perfil->getNome($_SESSION['adm_equilibrare']['funcionario']['id']), ' ')?>
                    <?=$this->perfil->getFoto($_SESSION['adm_equilibrare']['funcionario']['id']);?><?=substr($this->perfil->getNome($_SESSION['adm_equilibrare']['funcionario']['id']), 0,$pos)?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?=base_url('funcionario/form/').$_SESSION['adm_equilibrare']['funcionario']['id'];?>"> Perfil</a></li>
                    <li><a href="<?=base_url('main/logOff')?>"><i class="fa fa-sign-out pull-right"></i> Sair</a></li>
                  </ul>
                </li>
				<!--li role="presentation" class="dropdown"-->
                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="true">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green"><?=$this->inbox->getTotMensagens()?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <?=$this->inbox->showNavigation()?>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
