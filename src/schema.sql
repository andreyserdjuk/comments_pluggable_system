create table comments(
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `table_id` int,
	`subject_id` int,
	`title` varchar(160),
	`content` varchar(512),
	`author` varchar(20),
  `created_at` TIMESTAMP,
  `status` SMALLINT,
	primary key (`id`),
  INDEX subject_idx(`table_id`, `subject_id`)
);

create table observers(
  `observer_priority` int,
  `observer_name` VARCHAR(512),
  `event_name` VARCHAR(64),
  INDEX observer_priority_idx(`observer_priority`)
);

create table smileys(
  `smile_code` char(10),
  `img_src` VARCHAR(120)
);

insert into observers values
  (1000, 'CommentsPluggableSystem\\Observers\\SubmitValidatorObserver', 'form.on_submit'),
  (999, 'CommentsPluggableSystem\\Observers\\SubmitFilterObserver', 'form.on_submit'),
  (998, 'CommentsPluggableSystem\\Observers\\SubmitCreatorObserver', 'form.on_submit'),
  (997, 'CommentsPluggableSystem\\Observers\\SubmitSaverObserver', 'form.on_submit')
;

INSERT INTO smileys VALUES
  (':)', 'smile1.jpg'),
  (':(', 'smile2.jpg'),
  (';)', 'smile3.jpg')
;