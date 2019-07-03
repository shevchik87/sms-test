/**
 I think that query will execute every day for previous day
 */


INSERT INTO send_log_aggregated(log_agg_date, log_agg_usr_id, log_agg_cnt_id, log_agg_count_sent_success, log_agg_count_sent_fail)
SELECT
  date(log_crated),
  usr_id,
  n.cnt_id,
  sum(if(log_success=1, 1, 0)),
  sum(if(log_success=0, 1, 0))
FROM send_log
  JOIN numbers n ON n.num_id = send_log.num_id
WHERE date(send_log.log_crated) = DATE_SUB(date(NOW()), INTERVAL 1 DAY) /** previous day**/
GROUP BY date(log_crated), usr_id, n.cnt_id;


DELETE FROM send_log WHERE date(log_crated) = DATE_SUB(date(NOW()), INTERVAL 1 DAY)



