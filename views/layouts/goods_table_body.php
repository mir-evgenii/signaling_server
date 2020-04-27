<tbody>
  <tr>
    <td><?=$this->params['good']?></td>
    <td><?=$this->params['price']?></td>
    <td><?=$this->params['number']?></td>
    <td>
      <a href='index.php?r=site/change-good&id=<?=$this->params['id']?>'>
        Изменить
      </a>
    </td>
    <td>
      <a href='#' role='button' data-toggle='modal' data-target='#exampleModalCenter<?=$this->params['id']?>'>
        Удалить
      </a>
      <div class='modal fade' id='exampleModalCenter<?=$this->params['id']?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title' id='exampleModalLongTitle'>Удаление товара</h5>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Отмена</button>
              <a class='btn btn-danger' 
              href='index.php?r=site/index&id=<?=$this->params['id_this_category']?>&id_del_good=<?=$this->params['id']?>' 
              role='button'>
                Удалить
              </a>
            </div>
          </div>
        </div>
      </div>
    </td>
  </tr>
</tbody>