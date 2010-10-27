<?php // Vars: $dmNewsArticlePager

echo $dmNewsArticlePager->renderNavigationTop();

echo _open('ul.elements');

foreach ($dmNewsArticlePager as $dmNewsArticle)
{
  echo _open('li.element');

    echo _link($dmNewsArticle);

  echo _close('li');
}

echo _close('ul');

echo $dmNewsArticlePager->renderNavigationBottom();