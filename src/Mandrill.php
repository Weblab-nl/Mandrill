<?php
namespace Weblab;

/**
 * Helper class to send emails using the Mandrill RESTful API
 *
 * @author Weblab.nl - Thomas Marinissen
 */
class Mandrill {

    /**
     * The mail subject
     *
     * @var string
     */
    protected $subject = '';

    /**
     * The mail from name
     *
     * @var string
     */
    protected $fromName = '';

    /**
     * The mail from address
     *
     * @var string
     */
    protected $fromAddress = '';

    /**
     * The mail bcc address
     *
     * @var string
     */
    protected $bccAddress = '';

    /**
     * The google analytics campaign name
     *
     * @var string
     */
    protected $campaignName = '';

    /**
     * Whether the text version should be generated automatically
     *
     * @var bool
     */
    protected $autoText = true;

    /**
     * Whether opens should be tracked
     *
     * @var bool
     */
    protected $trackOpens = true;

    /**
     * Whether clicks on content links should be tracked
     *
     * @var bool
     */
    protected $viewContentLinks = true;

    /**
     * Whether clicks should be tracked
     *
     * @var bool
     */
    protected $trackClicks = true;

    /**
     * Whether css should be converted inline or not
     *
     * @var bool
     */
    protected $inlineCss = true;

    /**
     * The domains for what google analytics parameters will be automatically appended to
     *
     * @var array
     */
    protected $analyticsDomains = array();

    /**
     * The global merge variables
     *
     * @var array
     */
    protected $globalMergeVars = array();

    /**
     * The to addresses
     *
     * @var array
     */
    protected $toAddresses = array();

    /**
     * The reply to address
     *
     * @var string
     */
    protected $replyTo = null;

    /**
     * The mailchimp template to use for the email
     *
     * @var string
     */
    protected $templateName;

    /**
     * The attachments
     *
     * @var array
     */
    protected $attachments = [];

    /**
     * The Mandrill api instance
     *
     * @var \Mandrill|null
     */
    protected $mandrill = null;

    /**
     * The mandrill api key
     *
     * @var
     */
    protected $key;

    /**
     * Constructor
     *
     * @param   string                  The mandrill RESTful API key
     */
    public function __construct($key) {
        // set the mandrill api key
        $this->key = $key;
    }

    /**
     * Get the set subject
     *
     * @return string                           The subject
     */
    public function subject() {
        return $this->subject;
    }

    /**
     * Get the from name
     *
     * @return string
     */
    public function fromName() {
        return $this->fromName;
    }

    /**
     * get the from address
     *
     * @return string                               The from name
     */
    public function fromAddress() {
        return $this->fromAddress;
    }

    /**
     * Get the bcc address
     *
     * @return string                               The bcc address
     */
    public function bccAddress() {
        return $this->bccAddress;
    }

    /**
     * Get the google analytics campaign name
     *
     * @return string                               The campaign name
     */
    public function campaignName() {
        return $this->campaignName;
    }

    /**
     * Get whether the auto text is set
     *
     * @return boolean                              Whether the auto text is set
     */
    public function isAutoText() {
        return $this->autoText;
    }

    /**
     * Get whether opens should be tracked
     *
     * @return boolean                              Whether opens should be tracked
     */
    public function isTrackOpens() {
        return $this->trackOpens;
    }

    /**
     * Get whether content links should be logged
     *
     * @return boolean                              Whether content links should be logged
     */
    public function isViewContentLinks() {
        return $this->viewContentLinks;
    }

    /**
     * Get whether clicks should be tracked
     *
     * @return boolean                              Whether clicks should be tracked
     */
    public function isTrackClicks() {
        return $this->trackClicks;
    }

    /**
     * Get whether css should be made inline or not
     *
     * @return boolean                              Whether css should be made inline or not
     */
    public function isInlineCss() {
        return $this->inlineCss;
    }

    /**
     * Get the analytics domains for what clicks should be logged
     *
     * @return array                                The domains to log using google analytics
     */
    public function analyticsDomains() {
        return $this->analyticsDomains;
    }

    /**
     * Get the global merge vars
     *
     * @return array                                The global merge vars
     */
    public function globalMergeVars() {
        return $this->globalMergeVars;
    }

    /**
     * Get the to addresses
     *
     * @return array                                The to addresses
     */
    public function toAddresses() {
        return $this->toAddresses;
    }

    /**
     * Get the reply to address
     *
     * @return string                               The reply to address
     */
    public function replyTo() {
        return $this->replyTo;
    }

    /**
     * Get the attachments
     *
     * @return array                The information of every attachment
     */
    public function attachments() {
        return $this->attachments;
    }

    /**
     * Get the template name
     *
     * @return string                               The template name
     */
    public function templateName() {
        return $this->templateName;
    }

    /**
     * Get the mandrill RESTfull API instance, create a new instance if it is not known yet
     *
     * @return Mandrill|null
     */
    public function mandrill() {
        // if the api instance is known already, return it
        if (!is_null($this->mandrill)) {
            return $this->mandrill;
        }

        // create a new api instance
        return $this->mandrill = new \Mandrill($this->key);
    }

    /**
     * Set the subject
     *
     * @param   string                              The subject
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function setSubject($subject) {
        // set the subject
        $this->subject = $subject;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Set the from address
     *
     * @param   string                              The from address
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function setFromAddress($fromName, $fromAddress) {
        // set the from name
        $this->fromName = $fromName;

        // set the fromAddress
        $this->fromAddress = $fromAddress;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Set the bcc address
     *
     * @param   string                              The bcc address
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function setBccAddress($bccAddress) {
        // set the bccAddress
        $this->bccAddress = $bccAddress;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Set the analytics campaign name
     *
     * @param   string                              The analytics campaign name
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function setAnalyticsCampaign($campaignName) {
        // set the campaignName
        $this->campaignName = $campaignName;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Whether or not to automatically generate a text part for messages that are not given text
     *
     * @param   bool                                whether or not to automatically generate a text part for messages that are not given text
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function setAutoText(bool $autoText) {
        // set the auto text value
        $this->autoText = $autoText;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Whether or not to turn on open tracking for the message
     *
     * @param   bool                                Whether or not to turn on open tracking for the message
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function setTrackOpens(bool $trackOpens) {
        // set whether opens should be tracked
        $this->trackOpens = $trackOpens;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Set whether content links should be logged
     *
     * @param   bool                                Whether content links should be logged or not
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function setViewContentLinks(bool $viewContentLinks) {
        // set whether content links should be logged
        $this->viewContentLinks = $viewContentLinks;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Set whether or not to turn on click tracking for the message
     *
     * @param   bool                                Whether or not to turn on click tracking for the message
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function setTrackClicks(bool $trackClicks) {
        // set whether clicks should be tracked
        $this->trackClicks = $trackClicks;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Set whether css has to be set inline
     *
     * @param   bool                                Whether or no to convert css to inline
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function setInlineCss(bool $inlineCss) {
        // set whether the css should be made inline
        $this->inlineCss = $inlineCss;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Add domain for what the google analytics parameters will be automatically appended to
     *
     * @param   string                              Google analytics domain to add
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function addAnalyticsDomain($domain) {
        // add an analytics domain
        $this->analyticsDomains[] = $domain;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Add a global merge variable
     *
     * @param   string                              The name for the global merge variable in the template
     * @param   string                              The content of the global merge variable
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function addGlobalmergeVar($name, $content) {
        // add teh global merge variable
        $this->globalMergeVars[] = array(
            'name'      => $name,
            'content'   => $content,
        );

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Add a to address
     *
     * @param   string                              The name for the to address
     * @param   string                              The email address to send the email to
     * @param   string                              The type of address to add (to, cc or bcc)
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function addToAddress($name, $email, $type = 'to') {
        // add teh global merge variable
        $this->toAddresses[] = array(
            'name'      => $name,
            'email'     => $email,
            'type'      => $type,
        );

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Set the reply to address
     *
     * @param   string                              The reply to address
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function setReplyTo($email) {
        // set the reply to address
        $this->replyTo = $email;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Set the template name to use
     *
     * @param   string                              The template to set
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function setTemplate($template) {
        // set the template
        $this->templateName = $template;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Add an attachment to the email. An attachment is an array containing 3 fields; content, name and type. The content
     * is the base64 encoded file to send along the email (example: base64_encode('/path/to/the/attachment')), the name
     * is the name of the attachment (example: 'test.pdf') and the type (example: 'application/pdf')
     *
     * @param   array                               The attachment information
     * @return  \Weblab\Mandrill                    The instance of this, to make chaining possible
     */
    public function addAttachment(array $attachment) {
        // add the attachment to the list of attachments
        $this->attachments[] = $attachment;

        // return the instance of this, to make chaining possible
        return $this;
    }

    /**
     * Send out an email using mandrill
     *
     * @return  array                               The email result
     * @throws \Exception                           Thrown whenever there is no template given or no to address is set
     */
    public function send() {
        // if there is no template, throw a new exception
        if (empty($this->templateName)) {
            throw new \Exception('No template set');
        }

        // if there is no to address set, throw an exception
        if (empty($this->toAddresses)) {
            throw new \Exception('No to address given');
        }

        // send the email and return the send result
        return $this->mandrill()->messages->sendTemplate($this->templateName, array(), $this->options());
    }

    /**
     * Helper function to get the options, needed to send out an email using
     * mandrill
     *
     * @return  array                               The mandrill settings
     */
    protected function options() {
        // set the base mandrill settings
        $settings = array(
            'subject'                   => $this->subject(),
            'from_email'                => $this->fromAddress(),
            'from_name'                 => $this->fromName(),
            'auto_text'                 => $this->isAutoText(),
            'track_opens'               => $this->isTrackOpens(),
            'view_content_link'         => $this->isViewContentLinks(),
            'track_clicks'              => $this->isTrackClicks(),
            'google_analytics_domains'  => $this->analyticsDomains(),
            'inline_css'                => $this->isInlineCss(),
            'global_merge_vars'         => $this->globalMergeVars(),
            'to'                        => $this->toAddresses(),
        );

        // get the reply to addres
        $replyTo = $this->replyTo();

        // if there is a reply to address set, add it
        if (!is_null($replyTo)) {
            $settings['headers'] = array(
                'Reply-To' => $replyTo,
            );
        }

        // set the bcc address if set
        $bccAddress = $this->bccAddress();
        if (!empty($bccAddress)) {
            $settings['bcc_address'] = $bccAddress;
        }

        // add the attachments if set
        $attachments = $this->attachments();
        if (!empty($attachments)) {
            $settings['attachments'] = $attachments;
        }

        // get the campaign name
        $campaignName = $this->campaignName();

        // set the campaign name if set
        if (!empty($campaignName)) {
            $settings['google_analytics_campaign'] = $campaignName;
        }

        // done, return the settings
        return $settings;
    }
}
