<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class DocContentFormatUserInfo
{

    public function main_content($login, $array){
        $table_content = "";

        foreach($array as $key => $value){
            $table_content .= "<w:tr wsp:rsidR=\"00000000\" wsp:rsidRPr=\"002334C3\" wsp:rsidTr=\"002334C3\">
					<w:tc>
						<w:tcPr>
							<w:tcW w:w=\"4672\" w:type=\"dxa\"/>
                            <w:tcBorders>
								<w:top w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:left w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:bottom w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:right w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
							</w:tcBorders>
                            <w:shd w:val=\"clear\" w:color=\"auto\" w:fill=\"auto\"/>
						</w:tcPr>
                        <w:p wsp:rsidR=\"00000000\" wsp:rsidRPr=\"002334C3\" wsp:rsidRDefault=\"00D63AE1\" wsp:rsidP=\"002334C3\">
							<w:pPr>
								<w:spacing w:after=\"0\" w:line=\"240\" w:line-rule=\"auto\"/>
                                <w:rPr>
									<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                                    <wx:font wx:val=\"Times New Roman\"/>
                                    <w:sz w:val=\"28\"/>
                                    <w:sz-cs w:val=\"28\"/>
								</w:rPr>
							</w:pPr>
                            <w:r wsp:rsidRPr=\"002334C3\">
								<w:rPr>
									<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                                    <wx:font wx:val=\"Times New Roman\"/>
                                    <w:sz w:val=\"28\"/>
                                    <w:sz-cs w:val=\"28\"/>
								</w:rPr>
                                <w:t>$key</w:t>
							</w:r>
						</w:p>
					</w:tc>
                    <w:tc>
						<w:tcPr>
							<w:tcW w:w=\"4673\" w:type=\"dxa\"/>
                            <w:tcBorders>
								<w:top w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:left w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:bottom w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:right w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
							</w:tcBorders>
                            <w:shd w:val=\"clear\" w:color=\"auto\" w:fill=\"auto\"/>
						</w:tcPr>
                        <w:p wsp:rsidR=\"00000000\" wsp:rsidRPr=\"002334C3\" wsp:rsidRDefault=\"00D63AE1\" wsp:rsidP=\"002334C3\">
							<w:pPr>
								<w:spacing w:after=\"0\" w:line=\"240\" w:line-rule=\"auto\"/>
                                <w:rPr>
									<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                                    <wx:font wx:val=\"Times New Roman\"/>
                                    <w:sz w:val=\"28\"/>
                                    <w:sz-cs w:val=\"28\"/>
                                    <w:lang w:val=\"EN-US\"/>
								</w:rPr>
							</w:pPr>
                            <w:r wsp:rsidRPr=\"002334C3\">
								<w:rPr>
									<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                                    <wx:font wx:val=\"Times New Roman\"/>
                                    <w:sz w:val=\"28\"/>
                                    <w:sz-cs w:val=\"28\"/>
                                    <w:lang w:val=\"EN-US\"/>
								</w:rPr>
                                <w:t>$value</w:t>
							</w:r>
						</w:p>
					</w:tc>
				</w:tr>";
        }

        return "

    <w:body>
		<wx:sect>
			<w:p wsp:rsidR=\"00000000\" wsp:rsidRDefault=\"00D63AE1\">
				<w:pPr>
					<w:rPr>
						<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                        <wx:font wx:val=\"Times New Roman\"/>
                        <w:sz w:val=\"28\"/>
                        <w:sz-cs w:val=\"28\"/>
					</w:rPr>
				</w:pPr>
                <w:r>
					<w:rPr>
						<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                        <wx:font wx:val=\"Times New Roman\"/>
                        <w:b/>
                        <w:b-cs/>
                        <w:sz w:val=\"28\"/>
                        <w:sz-cs w:val=\"28\"/>
					</w:rPr>
                    <w:t>Данные о пользователе: </w:t>
				</w:r>
                <w:r>
					<w:rPr>
						<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                        <wx:font wx:val=\"Times New Roman\"/>
                        <w:b/>
                        <w:b-cs/>
                        <w:sz w:val=\"28\"/>
                        <w:sz-cs w:val=\"28\"/>
                        <w:lang w:val=\"EN-US\"/>
					</w:rPr>
                    <w:t>$login</w:t>
				</w:r>
			</w:p>
            <w:tbl>
				<w:tblPr>
					<w:tblW w:w=\"0\" w:type=\"auto\"/>
                    <w:tblBorders>
						<w:top w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                        <w:left w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                        <w:bottom w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                        <w:right w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                        <w:insideH w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                        <w:insideV w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
					</w:tblBorders>
                    <w:tblLook w:val=\"04A0\"/>
				</w:tblPr>
                <w:tblGrid>
					<w:gridCol w:w=\"4672\"/>
                    <w:gridCol w:w=\"4673\"/>
				</w:tblGrid>
                <w:tr wsp:rsidR=\"00000000\" wsp:rsidRPr=\"002334C3\" wsp:rsidTr=\"002334C3\">
					<w:tc>
						<w:tcPr>
							<w:tcW w:w=\"4672\" w:type=\"dxa\"/>
                            <w:tcBorders>
								<w:top w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:left w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:bottom w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:right w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
							</w:tcBorders>
                            <w:shd w:val=\"clear\" w:color=\"auto\" w:fill=\"auto\"/>
						</w:tcPr>
                        <w:p wsp:rsidR=\"00000000\" wsp:rsidRPr=\"002334C3\" wsp:rsidRDefault=\"00D63AE1\" wsp:rsidP=\"002334C3\">
							<w:pPr>
								<w:spacing w:after=\"0\" w:line=\"240\" w:line-rule=\"auto\"/>
                                <w:rPr>
									<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                                    <wx:font wx:val=\"Times New Roman\"/>
                                    <w:b/>
                                    <w:b-cs/>
                                    <w:sz w:val=\"28\"/>
                                    <w:sz-cs w:val=\"28\"/>
								</w:rPr>
							</w:pPr>
                            <w:r wsp:rsidRPr=\"002334C3\">
								<w:rPr>
									<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                                    <wx:font wx:val=\"Times New Roman\"/>
                                    <w:b/>
                                    <w:b-cs/>
                                    <w:sz w:val=\"28\"/>
                                    <w:sz-cs w:val=\"28\"/>
								</w:rPr>
                                <w:t>Позиция</w:t>
							</w:r>
						</w:p>
					</w:tc>
                    <w:tc>
						<w:tcPr>
							<w:tcW w:w=\"4673\" w:type=\"dxa\"/>
                            <w:tcBorders>
								<w:top w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:left w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:bottom w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                                <w:right w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
							</w:tcBorders>
                            <w:shd w:val=\"clear\" w:color=\"auto\" w:fill=\"auto\"/>
						</w:tcPr>
                        <w:p wsp:rsidR=\"00000000\" wsp:rsidRPr=\"002334C3\" wsp:rsidRDefault=\"00D63AE1\" wsp:rsidP=\"002334C3\">
							<w:pPr>
								<w:spacing w:after=\"0\" w:line=\"240\" w:line-rule=\"auto\"/>
                                <w:rPr>
									<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                                    <wx:font wx:val=\"Times New Roman\"/>
                                    <w:b/>
                                    <w:b-cs/>
                                    <w:sz w:val=\"28\"/>
                                    <w:sz-cs w:val=\"28\"/>
								</w:rPr>
							</w:pPr>
                            <w:r wsp:rsidRPr=\"002334C3\">
								<w:rPr>
									<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                                    <wx:font wx:val=\"Times New Roman\"/>
                                    <w:b/>
                                    <w:b-cs/>
                                    <w:sz w:val=\"28\"/>
                                    <w:sz-cs w:val=\"28\"/>
								</w:rPr>
                                <w:t>Значение</w:t>
							</w:r>
						</w:p>
					</w:tc>
				</w:tr>

				$table_content

			</w:tbl>

        ";
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @return string|null
     */
    public function template_start()
    {
        return "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>
<?mso-application progid=\"Word.Document\"?>
<w:wordDocument
    xmlns:aml=\"http://schemas.microsoft.com/aml/2001/core\"
    xmlns:wpc=\"http://schemas.microsoft.com/office/word/2010/wordprocessingCanvas\"
    xmlns:cx=\"http://schemas.microsoft.com/office/drawing/2014/chartex\"
    xmlns:cx1=\"http://schemas.microsoft.com/office/drawing/2015/9/8/chartex\"
    xmlns:cx2=\"http://schemas.microsoft.com/office/drawing/2015/10/21/chartex\"
    xmlns:cx3=\"http://schemas.microsoft.com/office/drawing/2016/5/9/chartex\"
    xmlns:cx4=\"http://schemas.microsoft.com/office/drawing/2016/5/10/chartex\"
    xmlns:cx5=\"http://schemas.microsoft.com/office/drawing/2016/5/11/chartex\"
    xmlns:cx6=\"http://schemas.microsoft.com/office/drawing/2016/5/12/chartex\"
    xmlns:cx7=\"http://schemas.microsoft.com/office/drawing/2016/5/13/chartex\"
    xmlns:cx8=\"http://schemas.microsoft.com/office/drawing/2016/5/14/chartex\"
    xmlns:dt=\"uuid:C2F41010-65B3-11d1-A29F-00AA00C14882\"
    xmlns:mc=\"http://schemas.openxmlformats.org/markup-compatibility/2006\"
    xmlns:aink=\"http://schemas.microsoft.com/office/drawing/2016/ink\"
    xmlns:am3d=\"http://schemas.microsoft.com/office/drawing/2017/model3d\"
    xmlns:o=\"urn:schemas-microsoft-com:office:office\"
    xmlns:v=\"urn:schemas-microsoft-com:vml\"
    xmlns:w10=\"urn:schemas-microsoft-com:office:word\"
    xmlns:w=\"http://schemas.microsoft.com/office/word/2003/wordml\"
    xmlns:wx=\"http://schemas.microsoft.com/office/word/2003/auxHint\"
    xmlns:wne=\"http://schemas.microsoft.com/office/word/2006/wordml\"
    xmlns:wsp=\"http://schemas.microsoft.com/office/word/2003/wordml/sp2\"
    xmlns:sl=\"http://schemas.microsoft.com/schemaLibrary/2003/core\" w:macrosPresent=\"no\" w:embeddedObjPresent=\"no\" w:ocxPresent=\"no\" xml:space=\"preserve\">
	<w:ignoreSubtree w:val=\"http://schemas.microsoft.com/office/word/2003/wordml/sp2\"/>
    <o:DocumentProperties>
		<o:Author>vladimir zaeb</o:Author>
        <o:LastAuthor>vladimir zaeb</o:LastAuthor>
        <o:Revision>2</o:Revision>
        <o:TotalTime>1</o:TotalTime>
        <o:Created>2022-03-27T14:35:00Z</o:Created>
        <o:LastSaved>2022-03-27T14:35:00Z</o:LastSaved>
        <o:Pages>1</o:Pages>
        <o:Words>45</o:Words>
        <o:Characters>262</o:Characters>
        <o:Lines>2</o:Lines>
        <o:Paragraphs>1</o:Paragraphs>
        <o:CharactersWithSpaces>306</o:CharactersWithSpaces>
        <o:Version>16</o:Version>
	</o:DocumentProperties>
    <w:fonts>
		<w:defaultFonts w:ascii=\"Calibri\" w:fareast=\"Calibri\" w:h-ansi=\"Calibri\" w:cs=\"Times New Roman\"/>
        <w:font w:name=\"Times New Roman\">
			<w:panose-1 w:val=\"02020603050405020304\"/>
            <w:charset w:val=\"CC\"/>
            <w:family w:val=\"Roman\"/>
            <w:pitch w:val=\"variable\"/>
            <w:sig w:usb-0=\"E0002EFF\" w:usb-1=\"C000785B\" w:usb-2=\"00000009\" w:usb-3=\"00000000\" w:csb-0=\"000001FF\" w:csb-1=\"00000000\"/>
		</w:font>
        <w:font w:name=\"Cambria Math\">
			<w:panose-1 w:val=\"02040503050406030204\"/>
            <w:charset w:val=\"00\"/>
            <w:family w:val=\"Roman\"/>
            <w:pitch w:val=\"variable\"/>
            <w:sig w:usb-0=\"00000003\" w:usb-1=\"00000000\" w:usb-2=\"00000000\" w:usb-3=\"00000000\" w:csb-0=\"00000001\" w:csb-1=\"00000000\"/>
		</w:font>
        <w:font w:name=\"Calibri\">
			<w:panose-1 w:val=\"020F0502020204030204\"/>
            <w:charset w:val=\"CC\"/>
            <w:family w:val=\"Swiss\"/>
            <w:pitch w:val=\"variable\"/>
            <w:sig w:usb-0=\"E4002EFF\" w:usb-1=\"C000247B\" w:usb-2=\"00000009\" w:usb-3=\"00000000\" w:csb-0=\"000001FF\" w:csb-1=\"00000000\"/>
		</w:font>
	</w:fonts>
    <w:styles>
		<w:versionOfBuiltInStylenames w:val=\"7\"/>
        <w:latentStyles w:defLockedState=\"off\" w:latentStyleCount=\"376\">
			<w:lsdException w:name=\"Normal\"/>
            <w:lsdException w:name=\"heading 1\"/>
            <w:lsdException w:name=\"heading 2\"/>
            <w:lsdException w:name=\"heading 3\"/>
            <w:lsdException w:name=\"heading 4\"/>
            <w:lsdException w:name=\"heading 5\"/>
            <w:lsdException w:name=\"heading 6\"/>
            <w:lsdException w:name=\"heading 7\"/>
            <w:lsdException w:name=\"heading 8\"/>
            <w:lsdException w:name=\"heading 9\"/>
            <w:lsdException w:name=\"index 1\"/>
            <w:lsdException w:name=\"index 2\"/>
            <w:lsdException w:name=\"index 3\"/>
            <w:lsdException w:name=\"index 4\"/>
            <w:lsdException w:name=\"index 5\"/>
            <w:lsdException w:name=\"index 6\"/>
            <w:lsdException w:name=\"index 7\"/>
            <w:lsdException w:name=\"index 8\"/>
            <w:lsdException w:name=\"index 9\"/>
            <w:lsdException w:name=\"toc 1\"/>
            <w:lsdException w:name=\"toc 2\"/>
            <w:lsdException w:name=\"toc 3\"/>
            <w:lsdException w:name=\"toc 4\"/>
            <w:lsdException w:name=\"toc 5\"/>
            <w:lsdException w:name=\"toc 6\"/>
            <w:lsdException w:name=\"toc 7\"/>
            <w:lsdException w:name=\"toc 8\"/>
            <w:lsdException w:name=\"toc 9\"/>
            <w:lsdException w:name=\"Normal Indent\"/>
            <w:lsdException w:name=\"footnote text\"/>
            <w:lsdException w:name=\"annotation text\"/>
            <w:lsdException w:name=\"header\"/>
            <w:lsdException w:name=\"footer\"/>
            <w:lsdException w:name=\"index heading\"/>
            <w:lsdException w:name=\"caption\"/>
            <w:lsdException w:name=\"table of figures\"/>
            <w:lsdException w:name=\"envelope address\"/>
            <w:lsdException w:name=\"envelope return\"/>
            <w:lsdException w:name=\"footnote reference\"/>
            <w:lsdException w:name=\"annotation reference\"/>
            <w:lsdException w:name=\"line number\"/>
            <w:lsdException w:name=\"page number\"/>
            <w:lsdException w:name=\"endnote reference\"/>
            <w:lsdException w:name=\"endnote text\"/>
            <w:lsdException w:name=\"table of authorities\"/>
            <w:lsdException w:name=\"macro\"/>
            <w:lsdException w:name=\"toa heading\"/>
            <w:lsdException w:name=\"List\"/>
            <w:lsdException w:name=\"List Bullet\"/>
            <w:lsdException w:name=\"List Number\"/>
            <w:lsdException w:name=\"List 2\"/>
            <w:lsdException w:name=\"List 3\"/>
            <w:lsdException w:name=\"List 4\"/>
            <w:lsdException w:name=\"List 5\"/>
            <w:lsdException w:name=\"List Bullet 2\"/>
            <w:lsdException w:name=\"List Bullet 3\"/>
            <w:lsdException w:name=\"List Bullet 4\"/>
            <w:lsdException w:name=\"List Bullet 5\"/>
            <w:lsdException w:name=\"List Number 2\"/>
            <w:lsdException w:name=\"List Number 3\"/>
            <w:lsdException w:name=\"List Number 4\"/>
            <w:lsdException w:name=\"List Number 5\"/>
            <w:lsdException w:name=\"Title\"/>
            <w:lsdException w:name=\"Closing\"/>
            <w:lsdException w:name=\"Signature\"/>
            <w:lsdException w:name=\"Default Paragraph Font\"/>
            <w:lsdException w:name=\"Body Text\"/>
            <w:lsdException w:name=\"Body Text Indent\"/>
            <w:lsdException w:name=\"List Continue\"/>
            <w:lsdException w:name=\"List Continue 2\"/>
            <w:lsdException w:name=\"List Continue 3\"/>
            <w:lsdException w:name=\"List Continue 4\"/>
            <w:lsdException w:name=\"List Continue 5\"/>
            <w:lsdException w:name=\"Message Header\"/>
            <w:lsdException w:name=\"Subtitle\"/>
            <w:lsdException w:name=\"Salutation\"/>
            <w:lsdException w:name=\"Date\"/>
            <w:lsdException w:name=\"Body Text First Indent\"/>
            <w:lsdException w:name=\"Body Text First Indent 2\"/>
            <w:lsdException w:name=\"Note Heading\"/>
            <w:lsdException w:name=\"Body Text 2\"/>
            <w:lsdException w:name=\"Body Text 3\"/>
            <w:lsdException w:name=\"Body Text Indent 2\"/>
            <w:lsdException w:name=\"Body Text Indent 3\"/>
            <w:lsdException w:name=\"Block Text\"/>
            <w:lsdException w:name=\"Hyperlink\"/>
            <w:lsdException w:name=\"FollowedHyperlink\"/>
            <w:lsdException w:name=\"Strong\"/>
            <w:lsdException w:name=\"Emphasis\"/>
            <w:lsdException w:name=\"Document Map\"/>
            <w:lsdException w:name=\"Plain Text\"/>
            <w:lsdException w:name=\"E-mail Signature\"/>
            <w:lsdException w:name=\"HTML Top of Form\"/>
            <w:lsdException w:name=\"HTML Bottom of Form\"/>
            <w:lsdException w:name=\"Normal (Web)\"/>
            <w:lsdException w:name=\"HTML Acronym\"/>
            <w:lsdException w:name=\"HTML Address\"/>
            <w:lsdException w:name=\"HTML Cite\"/>
            <w:lsdException w:name=\"HTML Code\"/>
            <w:lsdException w:name=\"HTML Definition\"/>
            <w:lsdException w:name=\"HTML Keyboard\"/>
            <w:lsdException w:name=\"HTML Preformatted\"/>
            <w:lsdException w:name=\"HTML Sample\"/>
            <w:lsdException w:name=\"HTML Typewriter\"/>
            <w:lsdException w:name=\"HTML Variable\"/>
            <w:lsdException w:name=\"Normal Table\"/>
            <w:lsdException w:name=\"annotation subject\"/>
            <w:lsdException w:name=\"No List\"/>
            <w:lsdException w:name=\"Outline List 1\"/>
            <w:lsdException w:name=\"Outline List 2\"/>
            <w:lsdException w:name=\"Outline List 3\"/>
            <w:lsdException w:name=\"Table Simple 1\"/>
            <w:lsdException w:name=\"Table Simple 2\"/>
            <w:lsdException w:name=\"Table Simple 3\"/>
            <w:lsdException w:name=\"Table Classic 1\"/>
            <w:lsdException w:name=\"Table Classic 2\"/>
            <w:lsdException w:name=\"Table Classic 3\"/>
            <w:lsdException w:name=\"Table Classic 4\"/>
            <w:lsdException w:name=\"Table Colorful 1\"/>
            <w:lsdException w:name=\"Table Colorful 2\"/>
            <w:lsdException w:name=\"Table Colorful 3\"/>
            <w:lsdException w:name=\"Table Columns 1\"/>
            <w:lsdException w:name=\"Table Columns 2\"/>
            <w:lsdException w:name=\"Table Columns 3\"/>
            <w:lsdException w:name=\"Table Columns 4\"/>
            <w:lsdException w:name=\"Table Columns 5\"/>
            <w:lsdException w:name=\"Table Grid 1\"/>
            <w:lsdException w:name=\"Table Grid 2\"/>
            <w:lsdException w:name=\"Table Grid 3\"/>
            <w:lsdException w:name=\"Table Grid 4\"/>
            <w:lsdException w:name=\"Table Grid 5\"/>
            <w:lsdException w:name=\"Table Grid 6\"/>
            <w:lsdException w:name=\"Table Grid 7\"/>
            <w:lsdException w:name=\"Table Grid 8\"/>
            <w:lsdException w:name=\"Table List 1\"/>
            <w:lsdException w:name=\"Table List 2\"/>
            <w:lsdException w:name=\"Table List 3\"/>
            <w:lsdException w:name=\"Table List 4\"/>
            <w:lsdException w:name=\"Table List 5\"/>
            <w:lsdException w:name=\"Table List 6\"/>
            <w:lsdException w:name=\"Table List 7\"/>
            <w:lsdException w:name=\"Table List 8\"/>
            <w:lsdException w:name=\"Table 3D effects 1\"/>
            <w:lsdException w:name=\"Table 3D effects 2\"/>
            <w:lsdException w:name=\"Table 3D effects 3\"/>
            <w:lsdException w:name=\"Table Contemporary\"/>
            <w:lsdException w:name=\"Table Elegant\"/>
            <w:lsdException w:name=\"Table Professional\"/>
            <w:lsdException w:name=\"Table Subtle 1\"/>
            <w:lsdException w:name=\"Table Subtle 2\"/>
            <w:lsdException w:name=\"Table Web 1\"/>
            <w:lsdException w:name=\"Table Web 2\"/>
            <w:lsdException w:name=\"Table Web 3\"/>
            <w:lsdException w:name=\"Balloon Text\"/>
            <w:lsdException w:name=\"Table Grid\"/>
            <w:lsdException w:name=\"Table Theme\"/>
            <w:lsdException w:name=\"Placeholder Text\"/>
            <w:lsdException w:name=\"No Spacing\"/>
            <w:lsdException w:name=\"Light Shading\"/>
            <w:lsdException w:name=\"Light List\"/>
            <w:lsdException w:name=\"Light Grid\"/>
            <w:lsdException w:name=\"Medium Shading 1\"/>
            <w:lsdException w:name=\"Medium Shading 2\"/>
            <w:lsdException w:name=\"Medium List 1\"/>
            <w:lsdException w:name=\"Medium List 2\"/>
            <w:lsdException w:name=\"Medium Grid 1\"/>
            <w:lsdException w:name=\"Medium Grid 2\"/>
            <w:lsdException w:name=\"Medium Grid 3\"/>
            <w:lsdException w:name=\"Dark List\"/>
            <w:lsdException w:name=\"Colorful Shading\"/>
            <w:lsdException w:name=\"Colorful List\"/>
            <w:lsdException w:name=\"Colorful Grid\"/>
            <w:lsdException w:name=\"Light Shading Accent 1\"/>
            <w:lsdException w:name=\"Light List Accent 1\"/>
            <w:lsdException w:name=\"Light Grid Accent 1\"/>
            <w:lsdException w:name=\"Medium Shading 1 Accent 1\"/>
            <w:lsdException w:name=\"Medium Shading 2 Accent 1\"/>
            <w:lsdException w:name=\"Medium List 1 Accent 1\"/>
            <w:lsdException w:name=\"Revision\"/>
            <w:lsdException w:name=\"List Paragraph\"/>
            <w:lsdException w:name=\"Quote\"/>
            <w:lsdException w:name=\"Intense Quote\"/>
            <w:lsdException w:name=\"Medium List 2 Accent 1\"/>
            <w:lsdException w:name=\"Medium Grid 1 Accent 1\"/>
            <w:lsdException w:name=\"Medium Grid 2 Accent 1\"/>
            <w:lsdException w:name=\"Medium Grid 3 Accent 1\"/>
            <w:lsdException w:name=\"Dark List Accent 1\"/>
            <w:lsdException w:name=\"Colorful Shading Accent 1\"/>
            <w:lsdException w:name=\"Colorful List Accent 1\"/>
            <w:lsdException w:name=\"Colorful Grid Accent 1\"/>
            <w:lsdException w:name=\"Light Shading Accent 2\"/>
            <w:lsdException w:name=\"Light List Accent 2\"/>
            <w:lsdException w:name=\"Light Grid Accent 2\"/>
            <w:lsdException w:name=\"Medium Shading 1 Accent 2\"/>
            <w:lsdException w:name=\"Medium Shading 2 Accent 2\"/>
            <w:lsdException w:name=\"Medium List 1 Accent 2\"/>
            <w:lsdException w:name=\"Medium List 2 Accent 2\"/>
            <w:lsdException w:name=\"Medium Grid 1 Accent 2\"/>
            <w:lsdException w:name=\"Medium Grid 2 Accent 2\"/>
            <w:lsdException w:name=\"Medium Grid 3 Accent 2\"/>
            <w:lsdException w:name=\"Dark List Accent 2\"/>
            <w:lsdException w:name=\"Colorful Shading Accent 2\"/>
            <w:lsdException w:name=\"Colorful List Accent 2\"/>
            <w:lsdException w:name=\"Colorful Grid Accent 2\"/>
            <w:lsdException w:name=\"Light Shading Accent 3\"/>
            <w:lsdException w:name=\"Light List Accent 3\"/>
            <w:lsdException w:name=\"Light Grid Accent 3\"/>
            <w:lsdException w:name=\"Medium Shading 1 Accent 3\"/>
            <w:lsdException w:name=\"Medium Shading 2 Accent 3\"/>
            <w:lsdException w:name=\"Medium List 1 Accent 3\"/>
            <w:lsdException w:name=\"Medium List 2 Accent 3\"/>
            <w:lsdException w:name=\"Medium Grid 1 Accent 3\"/>
            <w:lsdException w:name=\"Medium Grid 2 Accent 3\"/>
            <w:lsdException w:name=\"Medium Grid 3 Accent 3\"/>
            <w:lsdException w:name=\"Dark List Accent 3\"/>
            <w:lsdException w:name=\"Colorful Shading Accent 3\"/>
            <w:lsdException w:name=\"Colorful List Accent 3\"/>
            <w:lsdException w:name=\"Colorful Grid Accent 3\"/>
            <w:lsdException w:name=\"Light Shading Accent 4\"/>
            <w:lsdException w:name=\"Light List Accent 4\"/>
            <w:lsdException w:name=\"Light Grid Accent 4\"/>
            <w:lsdException w:name=\"Medium Shading 1 Accent 4\"/>
            <w:lsdException w:name=\"Medium Shading 2 Accent 4\"/>
            <w:lsdException w:name=\"Medium List 1 Accent 4\"/>
            <w:lsdException w:name=\"Medium List 2 Accent 4\"/>
            <w:lsdException w:name=\"Medium Grid 1 Accent 4\"/>
            <w:lsdException w:name=\"Medium Grid 2 Accent 4\"/>
            <w:lsdException w:name=\"Medium Grid 3 Accent 4\"/>
            <w:lsdException w:name=\"Dark List Accent 4\"/>
            <w:lsdException w:name=\"Colorful Shading Accent 4\"/>
            <w:lsdException w:name=\"Colorful List Accent 4\"/>
            <w:lsdException w:name=\"Colorful Grid Accent 4\"/>
            <w:lsdException w:name=\"Light Shading Accent 5\"/>
            <w:lsdException w:name=\"Light List Accent 5\"/>
            <w:lsdException w:name=\"Light Grid Accent 5\"/>
            <w:lsdException w:name=\"Medium Shading 1 Accent 5\"/>
            <w:lsdException w:name=\"Medium Shading 2 Accent 5\"/>
            <w:lsdException w:name=\"Medium List 1 Accent 5\"/>
            <w:lsdException w:name=\"Medium List 2 Accent 5\"/>
            <w:lsdException w:name=\"Medium Grid 1 Accent 5\"/>
            <w:lsdException w:name=\"Medium Grid 2 Accent 5\"/>
            <w:lsdException w:name=\"Medium Grid 3 Accent 5\"/>
            <w:lsdException w:name=\"Dark List Accent 5\"/>
            <w:lsdException w:name=\"Colorful Shading Accent 5\"/>
            <w:lsdException w:name=\"Colorful List Accent 5\"/>
            <w:lsdException w:name=\"Colorful Grid Accent 5\"/>
            <w:lsdException w:name=\"Light Shading Accent 6\"/>
            <w:lsdException w:name=\"Light List Accent 6\"/>
            <w:lsdException w:name=\"Light Grid Accent 6\"/>
            <w:lsdException w:name=\"Medium Shading 1 Accent 6\"/>
            <w:lsdException w:name=\"Medium Shading 2 Accent 6\"/>
            <w:lsdException w:name=\"Medium List 1 Accent 6\"/>
            <w:lsdException w:name=\"Medium List 2 Accent 6\"/>
            <w:lsdException w:name=\"Medium Grid 1 Accent 6\"/>
            <w:lsdException w:name=\"Medium Grid 2 Accent 6\"/>
            <w:lsdException w:name=\"Medium Grid 3 Accent 6\"/>
            <w:lsdException w:name=\"Dark List Accent 6\"/>
            <w:lsdException w:name=\"Colorful Shading Accent 6\"/>
            <w:lsdException w:name=\"Colorful List Accent 6\"/>
            <w:lsdException w:name=\"Colorful Grid Accent 6\"/>
            <w:lsdException w:name=\"Subtle Emphasis\"/>
            <w:lsdException w:name=\"Intense Emphasis\"/>
            <w:lsdException w:name=\"Subtle Reference\"/>
            <w:lsdException w:name=\"Intense Reference\"/>
            <w:lsdException w:name=\"Book Title\"/>
            <w:lsdException w:name=\"Bibliography\"/>
            <w:lsdException w:name=\"TOC Heading\"/>
            <w:lsdException w:name=\"Plain Table 1\"/>
            <w:lsdException w:name=\"Plain Table 2\"/>
            <w:lsdException w:name=\"Plain Table 3\"/>
            <w:lsdException w:name=\"Plain Table 4\"/>
            <w:lsdException w:name=\"Plain Table 5\"/>
            <w:lsdException w:name=\"Grid Table Light\"/>
            <w:lsdException w:name=\"Grid Table 1 Light\"/>
            <w:lsdException w:name=\"Grid Table 2\"/>
            <w:lsdException w:name=\"Grid Table 3\"/>
            <w:lsdException w:name=\"Grid Table 4\"/>
            <w:lsdException w:name=\"Grid Table 5 Dark\"/>
            <w:lsdException w:name=\"Grid Table 6 Colorful\"/>
            <w:lsdException w:name=\"Grid Table 7 Colorful\"/>
            <w:lsdException w:name=\"Grid Table 1 Light Accent 1\"/>
            <w:lsdException w:name=\"Grid Table 2 Accent 1\"/>
            <w:lsdException w:name=\"Grid Table 3 Accent 1\"/>
            <w:lsdException w:name=\"Grid Table 4 Accent 1\"/>
            <w:lsdException w:name=\"Grid Table 5 Dark Accent 1\"/>
            <w:lsdException w:name=\"Grid Table 6 Colorful Accent 1\"/>
            <w:lsdException w:name=\"Grid Table 7 Colorful Accent 1\"/>
            <w:lsdException w:name=\"Grid Table 1 Light Accent 2\"/>
            <w:lsdException w:name=\"Grid Table 2 Accent 2\"/>
            <w:lsdException w:name=\"Grid Table 3 Accent 2\"/>
            <w:lsdException w:name=\"Grid Table 4 Accent 2\"/>
            <w:lsdException w:name=\"Grid Table 5 Dark Accent 2\"/>
            <w:lsdException w:name=\"Grid Table 6 Colorful Accent 2\"/>
            <w:lsdException w:name=\"Grid Table 7 Colorful Accent 2\"/>
            <w:lsdException w:name=\"Grid Table 1 Light Accent 3\"/>
            <w:lsdException w:name=\"Grid Table 2 Accent 3\"/>
            <w:lsdException w:name=\"Grid Table 3 Accent 3\"/>
            <w:lsdException w:name=\"Grid Table 4 Accent 3\"/>
            <w:lsdException w:name=\"Grid Table 5 Dark Accent 3\"/>
            <w:lsdException w:name=\"Grid Table 6 Colorful Accent 3\"/>
            <w:lsdException w:name=\"Grid Table 7 Colorful Accent 3\"/>
            <w:lsdException w:name=\"Grid Table 1 Light Accent 4\"/>
            <w:lsdException w:name=\"Grid Table 2 Accent 4\"/>
            <w:lsdException w:name=\"Grid Table 3 Accent 4\"/>
            <w:lsdException w:name=\"Grid Table 4 Accent 4\"/>
            <w:lsdException w:name=\"Grid Table 5 Dark Accent 4\"/>
            <w:lsdException w:name=\"Grid Table 6 Colorful Accent 4\"/>
            <w:lsdException w:name=\"Grid Table 7 Colorful Accent 4\"/>
            <w:lsdException w:name=\"Grid Table 1 Light Accent 5\"/>
            <w:lsdException w:name=\"Grid Table 2 Accent 5\"/>
            <w:lsdException w:name=\"Grid Table 3 Accent 5\"/>
            <w:lsdException w:name=\"Grid Table 4 Accent 5\"/>
            <w:lsdException w:name=\"Grid Table 5 Dark Accent 5\"/>
            <w:lsdException w:name=\"Grid Table 6 Colorful Accent 5\"/>
            <w:lsdException w:name=\"Grid Table 7 Colorful Accent 5\"/>
            <w:lsdException w:name=\"Grid Table 1 Light Accent 6\"/>
            <w:lsdException w:name=\"Grid Table 2 Accent 6\"/>
            <w:lsdException w:name=\"Grid Table 3 Accent 6\"/>
            <w:lsdException w:name=\"Grid Table 4 Accent 6\"/>
            <w:lsdException w:name=\"Grid Table 5 Dark Accent 6\"/>
            <w:lsdException w:name=\"Grid Table 6 Colorful Accent 6\"/>
            <w:lsdException w:name=\"Grid Table 7 Colorful Accent 6\"/>
            <w:lsdException w:name=\"List Table 1 Light\"/>
            <w:lsdException w:name=\"List Table 2\"/>
            <w:lsdException w:name=\"List Table 3\"/>
            <w:lsdException w:name=\"List Table 4\"/>
            <w:lsdException w:name=\"List Table 5 Dark\"/>
            <w:lsdException w:name=\"List Table 6 Colorful\"/>
            <w:lsdException w:name=\"List Table 7 Colorful\"/>
            <w:lsdException w:name=\"List Table 1 Light Accent 1\"/>
            <w:lsdException w:name=\"List Table 2 Accent 1\"/>
            <w:lsdException w:name=\"List Table 3 Accent 1\"/>
            <w:lsdException w:name=\"List Table 4 Accent 1\"/>
            <w:lsdException w:name=\"List Table 5 Dark Accent 1\"/>
            <w:lsdException w:name=\"List Table 6 Colorful Accent 1\"/>
            <w:lsdException w:name=\"List Table 7 Colorful Accent 1\"/>
            <w:lsdException w:name=\"List Table 1 Light Accent 2\"/>
            <w:lsdException w:name=\"List Table 2 Accent 2\"/>
            <w:lsdException w:name=\"List Table 3 Accent 2\"/>
            <w:lsdException w:name=\"List Table 4 Accent 2\"/>
            <w:lsdException w:name=\"List Table 5 Dark Accent 2\"/>
            <w:lsdException w:name=\"List Table 6 Colorful Accent 2\"/>
            <w:lsdException w:name=\"List Table 7 Colorful Accent 2\"/>
            <w:lsdException w:name=\"List Table 1 Light Accent 3\"/>
            <w:lsdException w:name=\"List Table 2 Accent 3\"/>
            <w:lsdException w:name=\"List Table 3 Accent 3\"/>
            <w:lsdException w:name=\"List Table 4 Accent 3\"/>
            <w:lsdException w:name=\"List Table 5 Dark Accent 3\"/>
            <w:lsdException w:name=\"List Table 6 Colorful Accent 3\"/>
            <w:lsdException w:name=\"List Table 7 Colorful Accent 3\"/>
            <w:lsdException w:name=\"List Table 1 Light Accent 4\"/>
            <w:lsdException w:name=\"List Table 2 Accent 4\"/>
            <w:lsdException w:name=\"List Table 3 Accent 4\"/>
            <w:lsdException w:name=\"List Table 4 Accent 4\"/>
            <w:lsdException w:name=\"List Table 5 Dark Accent 4\"/>
            <w:lsdException w:name=\"List Table 6 Colorful Accent 4\"/>
            <w:lsdException w:name=\"List Table 7 Colorful Accent 4\"/>
            <w:lsdException w:name=\"List Table 1 Light Accent 5\"/>
            <w:lsdException w:name=\"List Table 2 Accent 5\"/>
            <w:lsdException w:name=\"List Table 3 Accent 5\"/>
            <w:lsdException w:name=\"List Table 4 Accent 5\"/>
            <w:lsdException w:name=\"List Table 5 Dark Accent 5\"/>
            <w:lsdException w:name=\"List Table 6 Colorful Accent 5\"/>
            <w:lsdException w:name=\"List Table 7 Colorful Accent 5\"/>
            <w:lsdException w:name=\"List Table 1 Light Accent 6\"/>
            <w:lsdException w:name=\"List Table 2 Accent 6\"/>
            <w:lsdException w:name=\"List Table 3 Accent 6\"/>
            <w:lsdException w:name=\"List Table 4 Accent 6\"/>
            <w:lsdException w:name=\"List Table 5 Dark Accent 6\"/>
            <w:lsdException w:name=\"List Table 6 Colorful Accent 6\"/>
            <w:lsdException w:name=\"List Table 7 Colorful Accent 6\"/>
            <w:lsdException w:name=\"Mention\"/>
            <w:lsdException w:name=\"Smart Hyperlink\"/>
            <w:lsdException w:name=\"Hashtag\"/>
            <w:lsdException w:name=\"Unresolved Mention\"/>
            <w:lsdException w:name=\"Smart Link\"/>
		</w:latentStyles>
        <w:style w:type=\"paragraph\" w:default=\"on\" w:styleId=\"a\">
			<w:name w:val=\"Normal\"/>
            <wx:uiName wx:val=\"Обычный\"/>
            <w:pPr>
				<w:spacing w:after=\"160\" w:line=\"256\" w:line-rule=\"auto\"/>
			</w:pPr>
            <w:rPr>
				<wx:font wx:val=\"Calibri\"/>
                <w:sz w:val=\"22\"/>
                <w:sz-cs w:val=\"22\"/>
                <w:lang w:val=\"RU\" w:fareast=\"EN-US\" w:bidi=\"AR-SA\"/>
			</w:rPr>
		</w:style>
        <w:style w:type=\"character\" w:default=\"on\" w:styleId=\"a0\">
			<w:name w:val=\"Default Paragraph Font\"/>
            <wx:uiName wx:val=\"Основной шрифт абзаца\"/>
		</w:style>
        <w:style w:type=\"table\" w:default=\"on\" w:styleId=\"a1\">
			<w:name w:val=\"Normal Table\"/>
            <wx:uiName wx:val=\"Обычная таблица\"/>
            <w:rPr>
				<wx:font wx:val=\"Calibri\"/>
                <w:lang w:val=\"RU\" w:fareast=\"RU\" w:bidi=\"AR-SA\"/>
			</w:rPr>
            <w:tblPr>
				<w:tblInd w:w=\"0\" w:type=\"dxa\"/>
                <w:tblCellMar>
					<w:top w:w=\"0\" w:type=\"dxa\"/>
                    <w:left w:w=\"108\" w:type=\"dxa\"/>
                    <w:bottom w:w=\"0\" w:type=\"dxa\"/>
                    <w:right w:w=\"108\" w:type=\"dxa\"/>
				</w:tblCellMar>
			</w:tblPr>
		</w:style>
        <w:style w:type=\"list\" w:default=\"on\" w:styleId=\"a2\">
			<w:name w:val=\"No List\"/>
            <wx:uiName wx:val=\"Нет списка\"/>
		</w:style>
        <w:style w:type=\"paragraph\" w:styleId=\"msonormal0\">
			<w:name w:val=\"msonormal\"/>
            <w:basedOn w:val=\"a\"/>
            <w:pPr>
				<w:spacing w:before=\"100\" w:before-autospacing=\"on\" w:after=\"100\" w:after-autospacing=\"on\" w:line=\"240\" w:line-rule=\"auto\"/>
			</w:pPr>
            <w:rPr>
				<w:rFonts w:ascii=\"Times New Roman\" w:fareast=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                <wx:font wx:val=\"Times New Roman\"/>
                <w:sz w:val=\"24\"/>
                <w:sz-cs w:val=\"24\"/>
                <w:lang w:fareast=\"RU\"/>
			</w:rPr>
		</w:style>
        <w:style w:type=\"table\" w:styleId=\"a3\">
			<w:name w:val=\"Table Grid\"/>
            <wx:uiName wx:val=\"Сетка таблицы\"/>
            <w:basedOn w:val=\"a1\"/>
            <w:rPr>
				<wx:font wx:val=\"Calibri\"/>
                <w:sz w:val=\"22\"/>
                <w:sz-cs w:val=\"22\"/>
			</w:rPr>
            <w:tblPr>
				<w:tblInd w:w=\"0\" w:type=\"nil\"/>
                <w:tblBorders>
					<w:top w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                    <w:left w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                    <w:bottom w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                    <w:right w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                    <w:insideH w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
                    <w:insideV w:val=\"single\" w:sz=\"4\" wx:bdrwidth=\"10\" w:space=\"0\" w:color=\"auto\"/>
				</w:tblBorders>
			</w:tblPr>
		</w:style>
	</w:styles>
    <w:shapeDefaults>
		<o:shapedefaults v:ext=\"edit\" spidmax=\"1026\"/>
        <o:shapelayout v:ext=\"edit\">
			<o:idmap v:ext=\"edit\" data=\"1\"/>
		</o:shapelayout>
	</w:shapeDefaults>
    <w:docPr>
		<w:view w:val=\"print\"/>
        <w:zoom w:percent=\"100\"/>
        <w:doNotEmbedSystemFonts/>
        <w:proofState w:spelling=\"clean\" w:grammar=\"clean\"/>
        <w:defaultTabStop w:val=\"708\"/>
        <w:punctuationKerning/>
        <w:characterSpacingControl w:val=\"DontCompress\"/>
        <w:optimizeForBrowser/>
        <w:allowPNG/>
        <w:validateAgainstSchema/>
        <w:saveInvalidXML w:val=\"off\"/>
        <w:ignoreMixedContent w:val=\"off\"/>
        <w:alwaysShowPlaceholderText w:val=\"off\"/>
        <w:compat>
			<w:breakWrappedTables/>
            <w:snapToGridInCell/>
            <w:wrapTextWithPunct/>
            <w:useAsianBreakRules/>
            <w:dontGrowAutofit/>
		</w:compat>
        <wsp:rsids>
			<wsp:rsidRoot wsp:val=\"00C0640B\"/>
            <wsp:rsid wsp:val=\"002334C3\"/>
            <wsp:rsid wsp:val=\"00C0640B\"/>
            <wsp:rsid wsp:val=\"00D63AE1\"/>
		</wsp:rsids>
	</w:docPr>
        ";
    }

    public function template_end(){
        return "
            <w:p wsp:rsidR=\"00D63AE1\" wsp:rsidRDefault=\"00D63AE1\">
				<w:pPr>
					<w:rPr>
						<w:rFonts w:ascii=\"Times New Roman\" w:h-ansi=\"Times New Roman\"/>
                        <wx:font wx:val=\"Times New Roman\"/>
                        <w:sz w:val=\"28\"/>
                        <w:sz-cs w:val=\"28\"/>
                        <w:lang w:val=\"EN-US\"/>
					</w:rPr>
				</w:pPr>
			</w:p>
            <w:sectPr wsp:rsidR=\"00D63AE1\">
				<w:pgSz w:w=\"11906\" w:h=\"16838\"/>
                <w:pgMar w:top=\"1134\" w:right=\"850\" w:bottom=\"1134\" w:left=\"1701\" w:header=\"708\" w:footer=\"708\" w:gutter=\"0\"/>
                <w:cols w:space=\"708\"/>
                <w:docGrid w:line-pitch=\"360\"/>
			</w:sectPr>
		</wx:sect>
	</w:body>
</w:wordDocument>
        ";
    }
}
