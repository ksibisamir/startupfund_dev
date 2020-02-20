<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">

            <tr>
                <td class="content-cell" align="center">
                    <p>
                        <a href="https://www.facebook.com/startupfund.tn" target="_blank"><img src="{{ asset('assets/images/mail-facebook.png') }}" width="25" height="25"></a>
                        <a href="https://www.linkedin.com/company/startup-fundtn" target="_blank"><img src="{{ asset('assets/images/mail-linkedin.png') }}" width="25" height="25"></a>
                        <a href="https://twitter.com/StartupFundTn" target="_blank"><img src="{{ asset('assets/images/mail-twiter.png') }}" width="25" height="25"></a>
                    </p>

                    <p>{{ Illuminate\Mail\Markdown::parse($slot) }}</p>

                    <p class="link"><a href="{{ route('contact_us') }}">@lang('app.Contact_Us')</a>  <a href="{{ route('dashboard') }}">@lang('app.My_account')</a></p>
                </td>
            </tr>
        </table>
    </td>
</tr>
