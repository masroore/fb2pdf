/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package org.trivee.fb2pdf;

/**
 *
 * @author vzeltser
 */
public class GeneralSettings {
    public boolean transliterateMetaInfo;
    public float imageDpi;
    public String overrideImageTransparency;
    public boolean ignoreEmptyLineBeforeImage;
    public boolean ignoreEmptyLineAfterImage;
    public boolean generateTOC;
    public float trackingSpaceCharRatio;
    public boolean strictImageSequence;
    public String hangingPunctuation = ".,;:'-";

    public GeneralSettings()
    {
    }
}