<div class="sf_admin_list">
  <?php if (!$pager->getNbResults()): ?>
    <h2><?php echo __('No result') ?></h2>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th><input class="sf_admin_list_batch_checkbox" type="checkbox" /></th>
          <?php include_partial('dmNewsLetterAdmin/list_th_tabular', array('sort' => $sort)) ?>
          <th></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th><input class="sf_admin_list_batch_checkbox" type="checkbox" /></th>
          <?php include_partial('dmNewsLetterAdmin/list_th_tabular', array('sort' => $sort)) ?>
          <th></th>
        </tr>
      </tfoot>
      <tbody class='{toggle_url: "<?php echo £link('@'.$helper->getUrlForAction('toggleBoolean'))->getHref() ?>"}'>
        <?php foreach ($pager->getResults() as $i => $dm_news_letter): $odd = fmod(++$i, 2) ? 'odd' : 'even' ?>
          <tr class="sf_admin_row <?php echo $odd ?> {pk: <?php echo $dm_news_letter->getPrimaryKey() ?>}">
            <td>
              <input type="checkbox" name="ids[]" value="<?php echo $dm_news_letter->getPrimaryKey() ?>" class="sf_admin_batch_checkbox" />
            </td>
            <?php include_partial('dmNewsLetterAdmin/list_td_tabular', array('dm_news_letter' => $dm_news_letter)) ?>
            <?php include_partial('dmNewsLetterAdmin/list_td_actions', array('dm_news_letter' => $dm_news_letter)) ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>