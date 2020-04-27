<tbody>
  <tr>
    <td>
      <a href='index.php?r=site/index&id=<?=$this->params['id']?>'>
        <?=$this->params['category']?>
      </a>
    </td>
    <td>
      <a href='index.php?r=site/change-category&id=<?=$this->params['id']?>'>
        Изменить
      </a>
    </td>
    <td>
      <a href='' role='button' data-toggle='modal' data-target='#exampleModalCenter<?=$this->params['id']?>'>
        Удалить
      </a>
      <div class='modal fade' id='exampleModalCenter<?=$this->params['id']?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title' id='exampleModalLongTitle'>Удаление категории</h5>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
              <div class='modal-body'>
                Категорию невозможно удалить если она содержит вложенные категории или вложенные товары.
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Отмена</button>
                <a class='btn btn-danger' href='index.php?r=site/index&id=<?=$this->params['id_this_category']?>&id_del_category=<?=$this->params['id']?>' role='button'>
                  Удалить
                </a>
              </div>
          </div>
        </div>
      </div>
    </td>
  </tr>
</tbody>