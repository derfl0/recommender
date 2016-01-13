<? if (!$courses): ?>
<p><?= sprintf(_('Leider wurden keine interessanten Kurse für %s gefunden'), $semester->name) ?></p>
<? else: ?>
    <table class="default">
        <caption><?= _('Interessante Kurse') ?> <?= htmlReady($semester->description ? : $semester->name) ?></caption>
        <thead>
            <tr>
                <th><?= _('Veranstaltungsnummer') ?></th>
                <th><?= _('Typ') ?></th>
                <th><?= _('Name') ?></th>
                <th><?= _('Dozent') ?></th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($courses as $course): ?>
                <tr>
                    <td><a href="<?= UrlHelper::getLink('details.php', array('sem_id' => $course->id)) ?>"><?= $course->Veranstaltungsnummer ?></a></td>
                    <td><a href="<?= UrlHelper::getLink('details.php', array('sem_id' => $course->id)) ?>"><?= $GLOBALS['SEM_TYPE'][$course->status]['name'] ?></a></td>
                    <td><a href="<?= UrlHelper::getLink('details.php', array('sem_id' => $course->id)) ?>"><?= $course->name ?></a></td>
                    <td>
                        <?= join(', ', array_map('ObjectdisplayHelper::link', $course->members->findBy('status', 'dozent')->pluck('user'))) ?>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
<? endif; 