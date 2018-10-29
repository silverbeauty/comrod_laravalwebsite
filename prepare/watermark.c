#include <gst/gst.h>
#include <glib.h>
#include <glib/gprintf.h>

/* Structure to contain all our information, so we can pass it to callbacks */
typedef struct _CustomData {
	GstElement *pipeline;
	GstElement *source;
	GstElement *decode;
	GstElement *videoscale;
	GstElement *audioconvert;
	GstElement *overlay;
	GstElement *videoconvert1;
	GstElement *videoconvert2;
	GstElement *videoencoder;
	GstElement *audioencoder;
	GstElement *muxer;
	GstElement *sink;
	GstCaps *caps;
	gint64 resolution;
	gchar *path;
} CustomData;
   
/* Handler for the pad-added signal */
static void pad_added_handler (GstElement *src, GstPad *pad, CustomData *data);
   
int main(int argc, char const *argv[]) {
  
	// check usage
	if (argc != 5) {
		g_printerr("Usage: %s path/to/watermarks/folder path/to/source/file path/to/dest/file resolution\n", argv[0]);
		return -1;	
	}

	CustomData data;
	GstBus *bus;
	GstMessage *msg;
	GstStateChangeReturn ret;
	gboolean terminate = FALSE;

	data.resolution = g_ascii_strtoll(argv[4], NULL, 0);
	data.path = g_strdup(argv[1]);

	/* Initialize GStreamer */
	gst_init (NULL, NULL);

	/* Create the elements */
	data.source = gst_element_factory_make ("filesrc", "source");
	data.decode = gst_element_factory_make("decodebin", "decode");
	data.videoscale = gst_element_factory_make("videoscale", "videoscale");
	data.audioconvert = gst_element_factory_make ("audioconvert", "audioconvert");
	data.overlay = gst_element_factory_make("gdkpixbufoverlay", "overlay");
	data.videoconvert1 = gst_element_factory_make("videoconvert", "videoconvert1");
	data.videoconvert2 = gst_element_factory_make("videoconvert", "videoconvert2");
	data.videoencoder = gst_element_factory_make("x264enc", "videoencoder");
	data.audioencoder = gst_element_factory_make("voaacenc", "audioencoder");
	data.muxer = gst_element_factory_make("mp4mux", "muxer");
	data.sink = gst_element_factory_make("filesink", "sink");

	/* Create the empty pipeline */
	data.pipeline = gst_pipeline_new ("test-pipeline");

	if (!data.pipeline || !data.source || !data.decode || !data.videoconvert1 || !data.videoconvert2 || !data.videoscale || !data.audioconvert || !data.overlay || !data.videoencoder || !data.audioencoder || !data.muxer || !data.sink ) {
		g_printerr ("Not all elements could be created.\n");
		return -1;
	}
   
	/* Build the pipeline. Note that we are NOT linking the source at this
	* point. We will do it later. */
	gst_bin_add_many (GST_BIN (data.pipeline), data.source, data.decode, data.videoscale, data.audioconvert , data.overlay, data.videoconvert1, data.videoconvert2, data.videoencoder, data.audioencoder, data.muxer, data.sink, NULL);
	if (!gst_element_link (data.source, data.decode)) {
		g_printerr ("Elements could not be linked.\n");
		gst_object_unref (data.pipeline);
		return -1;
	}
	if (!gst_element_link_many (data.audioconvert, data.audioencoder, data.muxer, NULL)) {
		g_printerr ("Elements could not be linked.\n");
		gst_object_unref (data.pipeline);
		return -1;
	}
	if (!gst_element_link_many (data.videoconvert1, data.videoscale, NULL)) {
		g_printerr ("Elements could not be linked.\n");
		gst_object_unref (data.pipeline);
		return -1;
	}
	if (!gst_element_link_many (data.overlay, data.videoconvert2, data.videoencoder, data.muxer, NULL)) {
		g_printerr ("Elements could not be linked.\n");
		gst_object_unref (data.pipeline);
		return -1;
	}
	if (!gst_element_link (data.muxer, data.sink)) {
		g_printerr ("Elements could not be linked.\n");
		gst_object_unref (data.pipeline);
		return -1;
	}
   
	/* Set the URI to play */
	g_object_set (data.source, "location", argv[2], NULL);
	g_object_set (data.overlay, "offset-x", 10, "offset-y", 10, NULL); 
	g_object_set (data.sink, "location", argv[3], NULL);
	g_object_set (data.videoencoder, "speed-preset", 8, NULL);

	/* Connect to the pad-added signal */
	g_signal_connect (data.decode, "pad-added", G_CALLBACK (pad_added_handler), &data);

	/* Start playing */
	ret = gst_element_set_state (data.pipeline, GST_STATE_PLAYING);
	if (ret == GST_STATE_CHANGE_FAILURE) {
		g_printerr ("Unable to set the pipeline to the playing state.\n");
		gst_object_unref (data.pipeline);
		return -1;
	}
   
	/* Listen to the bus */
	bus = gst_element_get_bus (data.pipeline);
	do {

		msg = gst_bus_timed_pop_filtered (bus, GST_CLOCK_TIME_NONE,
		GST_MESSAGE_STATE_CHANGED | GST_MESSAGE_ERROR | GST_MESSAGE_EOS);

		/* Parse message */
		if (msg != NULL) {
			GError *err;
			gchar *debug_info;

			switch (GST_MESSAGE_TYPE (msg)) {
				case GST_MESSAGE_ERROR:
					gst_message_parse_error (msg, &err, &debug_info);
					g_printerr ("Error received from element %s: %s\n", GST_OBJECT_NAME (msg->src), err->message);
					g_printerr ("Debugging information: %s\n", debug_info ? debug_info : "none");
					g_clear_error (&err);
					g_free (debug_info);
					terminate = TRUE;
					break;
				case GST_MESSAGE_EOS:
					g_print ("End-Of-Stream reached.\n");
					terminate = TRUE;
					break;
				case GST_MESSAGE_STATE_CHANGED:
					/* We are only interested in state-changed messages from the pipeline */
					if (GST_MESSAGE_SRC (msg) == GST_OBJECT (data.pipeline)) {
						GstState old_state, new_state, pending_state;
						gst_message_parse_state_changed (msg, &old_state, &new_state, &pending_state);
						g_print ("Pipeline state changed from %s to %s:\n",
						gst_element_state_get_name (old_state), gst_element_state_get_name (new_state));
					}
					break;
				default:
					/* We should not reach here */
					g_printerr ("Unexpected message received.\n");
					break;
			}
			gst_message_unref (msg);
		}

	} while (!terminate);
   
	/* Free resources */
	gst_object_unref (bus);
	gst_element_set_state (data.pipeline, GST_STATE_NULL);
	gst_object_unref (data.pipeline);
	return 0;
}
   
/* This function will be called by the pad-added signal */
static void pad_added_handler (GstElement *src, GstPad *new_pad, CustomData *data) {
	GstPad *sink_pad;
	GstPadLinkReturn ret;
	GstCaps *new_pad_caps = NULL;
	GstStructure *new_pad_struct = NULL;
	gchar buf[500];
	const gchar *new_pad_type = NULL;

	g_print ("Received new pad '%s' from '%s':\n", GST_PAD_NAME (new_pad), GST_ELEMENT_NAME (src));

	/* Check the new pad's type */
	new_pad_caps = gst_pad_get_current_caps (new_pad);
	new_pad_struct = gst_caps_get_structure (new_pad_caps, 0);
	new_pad_type = gst_structure_get_name (new_pad_struct);
	if (g_str_has_prefix (new_pad_type, "audio/x-raw")) {

		// audio path
		g_print ("  It has type '%s' which is raw audio.\n", new_pad_type);
		sink_pad = gst_element_get_static_pad (data->audioconvert, "sink");

		/* If our converter is already linked, we have nothing to do here */
		if (gst_pad_is_linked (sink_pad)) {
			g_print ("  We are already linked. Ignoring.\n");
			goto exit;
		}

		/* Attempt the link */
		ret = gst_pad_link (new_pad, sink_pad);
		if (GST_PAD_LINK_FAILED (ret)) {
			g_print ("  Type is '%s' but link failed.\n", new_pad_type);
		} else {
			g_print ("  Link succeeded (type '%s').\n", new_pad_type);
		}

	} else if (g_str_has_prefix (new_pad_type, "video/x-raw")) {

		// video path
		g_print ("  It has type '%s' which is raw video.\n", new_pad_type);

		if (data->resolution == 1080) {
			data->caps = gst_caps_new_simple(
				"video/x-raw",
				"width", G_TYPE_INT, 1920,
				"height", G_TYPE_INT, 1080,
				NULL
			);
			g_sprintf(buf, "%s/110.png", data->path);
			g_object_set (data->overlay, "location", buf, NULL);
			g_object_set (data->videoencoder, "bitrate", 6000, NULL);
		} else if (data->resolution == 720) {
			data->caps = gst_caps_new_simple(
				"video/x-raw",
				"width", G_TYPE_INT, 1280,
				"height", G_TYPE_INT, 720,
				NULL
			);
			g_sprintf(buf, "%s/90.png", data->path);
			g_object_set (data->overlay, "location", buf, NULL);
			g_object_set (data->videoencoder, "bitrate", 3500, NULL);
		} else {
			data->caps = gst_caps_new_simple(
				"video/x-raw",
				"width", G_TYPE_INT, 854,
				"height", G_TYPE_INT, 480,
				NULL
			);
			g_sprintf(buf, "%s/60.png", data->path);
			g_object_set (data->overlay, "location", buf, NULL);
			g_object_set (data->videoencoder, "bitrate", 2000, NULL);
		}

		sink_pad = gst_element_get_static_pad (data->videoconvert1, "sink");

		/* If our converter is already linked, we have nothing to do here */
		if (gst_pad_is_linked (sink_pad)) {
			g_print ("  We are already linked. Ignoring.\n");
			goto exit;
		}

		/* Attempt the link */
		ret = gst_pad_link (new_pad, sink_pad);
		if (GST_PAD_LINK_FAILED (ret)) {
			g_print ("  Type is '%s' but link failed.\n", new_pad_type);
		} else {
			g_print ("  Link succeeded (type '%s').\n", new_pad_type);
		}

		if (gst_element_link_filtered(data->videoscale, data->overlay, data->caps) != 1) {
			g_print ("  Filtered link failed\n");
		} else 
			g_print ("  Filtered link succeeded\n");

	} else {
		g_print ("  It has type '%s' which is not detected. Ignoring.\n", new_pad_type);
		goto exit;
	}

	exit:
		/* Unreference the new pad's caps, if we got them */
		if (new_pad_caps != NULL)
		gst_caps_unref (new_pad_caps);

		/* Unreference the sink pad */
		gst_object_unref (sink_pad);
}