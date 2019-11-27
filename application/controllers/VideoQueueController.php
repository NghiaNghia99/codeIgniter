<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 24-May-19
 * Time: 09:27
 */

class VideoQueueController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('movie');
        $this->load->model('videoqueue');
        $this->load->helper('url_helper', 'form', 'date', 'url');
    }

    public function index() {
        $queueList = $this->videoqueue->get_all_rule(array('conversionStarted' => 0));

        if (!empty($queueList)) {
            foreach ($queueList as $queue) {
                $queueID = $queue->job_id;
                $videoID = $queue->video_id;

                if ($this->videoqueue->update_rule(array('job_id' => $queueID), array('conversionStarted' => 1))) {
                    $video = $this->movie->get_info($videoID);
                    $path_ = $video->path;
                    $length = strlen($path_);
                    $path = FCPATH . substr($path_, 1, $length - 1);

                    //convert to *.mp4
                    $cmd = FCPATH . "bin/ffmpeg_mp4.sh" . " " . $path . "." . $video->ext . " " . $path . "_converted" . " " . $path . "_conversionLog.txt";

                    exec($cmd);

                    if (file_exists($path . "_converted.mp4.success")) {
                        $this->videoqueue->update_rule(array('job_id' => $queueID), array('mp4_status' => true));

                        $mp4_status = true;
                    } elseif (file_exists($path . "_converted.mp4.failed")) {
                        $this->videoqueue->update_rule(array('job_id' => $queueID), array('mp4_status' => false));

                        $mp4_status = false;
                    }

                    //convert to *.flv
                    $cmd = FCPATH . "bin/ffmpeg_flv.sh" . " " . $path . "." . $video->ext . " " . $path . "_converted" . " " . $path . "_conversionLog.txt";

                    exec($cmd);

                    if (file_exists($path . "_converted.flv.success")) {
                        $this->videoqueue->update_rule(array('job_id' => $queueID), array('flv_status' => true));

                        $flv_status = true;
                    } elseif (file_exists($path . "_converted.flv.failed")) {
                        $this->videoqueue->update_rule(array('job_id' => $queueID), array('flv_status' => false));

                        $flv_status = false;
                    }

                    //convert to *.webm
                    $cmd = FCPATH . "bin/ffmpeg_webm.sh" . " " . $path . "." . $video->ext . " " . $path . "_converted" . " " . $path . "_conversionLog.txt";

                    exec($cmd);

                    if (file_exists($path . "_converted.webm.success")) {
                        $this->videoqueue->update_rule(array('job_id' => $queueID), array('webm_status' => true));

                        $webm_status = true;
                    } elseif (file_exists($path . "_converted.webm.failed")) {
                        $this->videoqueue->update_rule(array('job_id' => $queueID), array('webm_status' => false));

                        $webm_status = false;
                    }

                    $dateOfConversion = time();
                    if ($mp4_status || $flv_status || $webm_status) {
                        $this->videoqueue->update_rule(array('job_id' => $queueID),
                          array('success' => true, 'dateOfConversion' => $dateOfConversion));
                        $this->movie->update($videoID, array('status' => 1));
                        if ($video->doi == 'requested') {
                            $this->session->set_userdata('post_type_doi', 'video');
                            $this->requestDoi($videoID);
                        }
                    } else {
                        $this->videoqueue->update_rule(array('job_id' => $queueID),
                          array('success' => false, 'dateOfConversion' => $dateOfConversion));
                        $this->movie->update($videoID, array('status' => 2));
                    }
                }
            }
        }
    }
}