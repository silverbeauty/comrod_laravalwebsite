#include <gst/gst.h>
#include <stdlib.h>
#include <glib.h>
#include <glib/gprintf.h>

/* Structure to contain all our information, so we can pass it to callbacks */
typedef struct _CustomData {
	GstElement *pipeline;
	GstElement *source;
	GstElement *decode;
	GstElement *videosink;
	GstElement *audiosink;
	gint resolution;
} CustomData;

/* Handler for the pad-added signal */
static void pad_added_handler (GstElement *src, GstPad *pad, CustomData *data);

int main(int argc, char *argv[])
{

	// check usage
	if (argc != 5) {
		g_printerr("Usage: %s path/to/watermarks/folder path/to/source/file path/to/dest/folder basename\n", argv[0]);
		return -1;	
	}

	CustomData data;
	GstBus *bus;
	GstMessage *msg;
	GstStateChangeReturn ret;
	gboolean terminate = FALSE;


	/* Initialize GStreamer */
	gst_init (NULL, NULL);

	// make a directory for encoded files
	gchar folder[500];
	g_sprintf(folder, "mkdir -p %s", argv[3]);
	if (system(folder) == -1) {
		g_printerr("Unable to create folder for encoded files. Check user rights\n");
		return -1;
	}

	/* Create the elements */
	data.source = gst_element_factory_make ("filesrc", "source");
	data.decode = gst_element_factory_make("decodebin", "decode");
	data.videosink = gst_element_factory_make("fakesink", "videosink");
	data.audiosink = gst_element_factory_make("fakesink", "audiosink");

	/* Create the empty pipeline */
	data.pipeline = gst_pipeline_new ("test-pipeline");

	if (!data.pipeline || !data.source || !data.decode || !data.videosink || !data.audiosink ) {
		g_printerr ("Not all elements could be created.\n");
		return -1;
	}
   
	/* Build the pipeline. Note that we are NOT linking the source at this
	* point. We will do it later. */
	gst_bin_add_many (GST_BIN (data.pipeline), data.source, data.decode, data.videosink, data.audiosink, NULL);
	if (!gst_element_link (data.source, data.decode)) {
		g_printerr ("Elements could not be linked.\n");
		gst_object_unref (data.pipeline);
		return -1;
	}
	
	/* Set the URI to play */
	g_object_set (data.source, "location", argv[2], NULL);

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


	/* main work on converting */
	char buf1[500];
	char buf2[500];
	char buf3[500];

	char filename[200];
	g_sprintf(filename, "%s/%s.smil", argv[3], argv[4]);
	FILE *smil = fopen(filename, "w");
	g_fprintf(smil, "<?xml version=\"1.0\" encoding=\"UTF-8\"?><smil title=\"\"><body><switch>");

	if (data.resolution >= 1080) {
		g_sprintf(buf1, "watermark %s %s %s/1080p_%s.mp4 1080", argv[1], argv[2], argv[3], argv[4]);
		system(buf1);
		g_fprintf(smil, "<video height=\"1080\" src=\"1080p_%s.mp4\" system-bitrate=\"6000000\" systemLanguage=\"eng\" width=\"1920\"></video>", argv[4]);

		g_sprintf(buf2, "watermark %s %s %s/720p_%s.mp4 720", argv[1], argv[2], argv[3], argv[4]);
		system(buf2);
		g_fprintf(smil, "<video height=\"720\" src=\"720p_%s.mp4\" system-bitrate=\"3500000\" systemLanguage=\"eng\" width=\"1280\"></video>", argv[4]);

		g_sprintf(buf3, "watermark %s %s %s/480p_%s.mp4 480", argv[1], argv[2], argv[3], argv[4]);
		system(buf3);
		g_fprintf(smil, "<video height=\"480\" src=\"480p_%s.mp4\" system-bitrate=\"2000000\" systemLanguage=\"eng\" width=\"854\"></video>", argv[4]);
	} else if (data.resolution >= 720) {
		g_sprintf(buf2, "watermark %s %s %s/720p_%s.mp4 720", argv[1], argv[2], argv[3], argv[4]);
		system(buf2);
		g_fprintf(smil, "<video height=\"720\" src=\"720p_%s.mp4\" system-bitrate=\"3500000\" systemLanguage=\"eng\" width=\"1280\"></video>", argv[4]);

		g_sprintf(buf3, "watermark %s %s %s/480p_%s.mp4 480", argv[1], argv[2], argv[3], argv[4]);
		system(buf3);
		g_fprintf(smil, "<video height=\"480\" src=\"480p_%s.mp4\" system-bitrate=\"2000000\" systemLanguage=\"eng\" width=\"854\"></video>", argv[4]);
	} else {
		g_sprintf(buf3, "watermark %s %s %s/480p_%s.mp4 480", argv[1], argv[2], argv[3], argv[4]);
		system(buf3);
		g_fprintf(smil, "<video height=\"480\" src=\"480p_%s.mp4\" system-bitrate=\"2000000\" systemLanguage=\"eng\" width=\"854\"></video>", argv[4]);
	}

	g_fprintf(smil, "</switch></body></smil>");
	fclose(smil);

	return 0;
}

/* This function will be called by the pad-added signal */
static void pad_added_handler (GstElement *src, GstPad *new_pad, CustomData *data) {
	GstPad *sink_pad;
	GstPadLinkReturn ret;
	GstCaps *new_pad_caps = NULL;
	GstStructure *new_pad_struct = NULL;
	const gchar *new_pad_type = NULL;

	g_print ("Received new pad '%s' from '%s':\n", GST_PAD_NAME (new_pad), GST_ELEMENT_NAME (src));

	/* Check the new pad's type */
	new_pad_caps = gst_pad_get_current_caps (new_pad);
	new_pad_struct = gst_caps_get_structure (new_pad_caps, 0);
	new_pad_type = gst_structure_get_name (new_pad_struct);
	if (g_str_has_prefix (new_pad_type, "audio/x-raw")) {

		// audio path
		g_print ("  It has type '%s' which is raw audio.\n", new_pad_type);
		sink_pad = gst_element_get_static_pad (data->audiosink, "sink");

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

		gst_structure_get_int(new_pad_struct, "height", &(data->resolution));
		g_print("  Video has %d height\n", data->resolution);
		sink_pad = gst_element_get_static_pad (data->videosink, "sink");

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