<div class="discussion-table">
    <table class="table align-middle">
        <thead class=table-primary>
            <tr>
                <th class="topic-col">Topic</th>
                <th>Started by</th>
                <th>Last post by</th>
                <th colspan="2">Posts</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['discussions'] as $dis) : ?>
                <tr>
                    <td class="topic-col">
                        <?php $link($dis->topic, 'Posts', 'PostsOfDiscussion',
                            ['did' => $dis->id, 'topic' => $dis->topic],  cssClass: 'topic-link'); ?>
                    </td>
                    <?php $endForm(); ?>
                    <td>
                        <b> <?php $htmlOut($dis->startUser);  ?></b>
                        <?php $htmlOut(' on '); ?> <br>
                        <?php $htmlOut($dis->startDateTime); ?>
                    </td>
                    <td>
                        <b> <?php $htmlOut($dis->lastUser); ?></b>
                        <?php $htmlOut(' on '); ?> <br>
                        <?php $htmlOut($dis->lastDateTime); ?>
                    </td>
                    <td><?php $htmlOut($dis->numberOfPosts); ?></td>
                    <td>
                        <?php if (isset($data['discussionsOfOneUser'])) { ?>
                            <!-- provide delete button if discussions of one user are shown -->
                            <div class="d-flex justify-content-end mb-2">
                            <button class="btn btn-outline-danger mr-2" type="button" 
                                    onclick="toggleDeleteButton(<?php $htmlOut(-$dis->id)?>)" 
                                    id="<?php $htmlOut(-$dis->id)?>deleteButton">
                                <i class="bi bi-trash"></i>
                            </button>
                            </div>
                            <div class="d-flex justify-content-end">
                            <?php $beginForm('Discussions', 'DeleteDiscussion', 
                                            ['did' => $dis->id], 'post') ?>
                                <button class="btn btn-outline-danger" type="submit"
                                        id="<?php $htmlOut(-$dis->id)?>deleteButtonConfirm" 
                                        style="display:none">
                                    <i class="bi bi-check"></i>
                                </button>
                            <?php $endForm(); ?>
                            </div>

                        <?php } else { ?>
                            <!-- provide link button if discussion of different users are shown -->
                            <?php $beginForm('Posts', 'PostsOfDiscussion', ['did' => $dis->id], 'get'); ?>
                            <button class="read-posts-btn">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                            <?php $endForm(); ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>