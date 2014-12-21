<div class="col-sm-3 col-md-2 sidebar">
    <?php echo $this->Form->create('Page'); ?>
    <?php echo $this->Form->input('loan_amount', array(
        'label' => 'The loan amount.',
        'type' => 'number',
        'placeholder' => '1000000',
        'required' => true
    )); ?>
    
    <?php echo $this->Form->input('term', array(
        'label' => 'Loan length in years.',
        'type' => 'number',
        'placeholder' => '30',
        'required' => true
    )); ?>
    
    <?php echo $this->Form->input('interest', array(
        'label' => 'Interest Rate',
        'type' => 'number', 
        'step' => 'any',
        'placeholder' => '3.5',
        'required' => true
    )); ?>
    <br/>
    <?php echo $this->Form->end('Calulate'); ?>
    <br/>
    <hr/>
    @create by <a href="https://github.com/squalltua" >pukkapol.tan</a>
</div><!-- /.sidebar -->

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <?php if (isset($pmt)) : ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <dl class="dl-horizontal">
                    <dt>Principal</dt>
                    <dd><?php echo number_format($loan_amount, 2); ?> Bath</dd>
                    <dt>Interest Rate</dt>
                    <dd><?php echo $interest; ?>%</dd>
                    <dt>Pay per month</dt>
                    <dd><?php echo number_format($pmt, 2); ?> Bath</dd>
                </dl>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Payment</th>
                    <th>Principal</th>
                    <th>Interest</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
            <?php $balance = $loan_amount; ?>
            <?php for($i = 1; $i <= ($term*12); $i++) : ?>
                <?php 
                    $interest_c = (($balance * ($interest/100))/12);
                    $base = $pmt - $interest_c;
                    $balance = $balance - $base;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo number_format($pmt, 2); ?></td>
                    <td><?php echo number_format($base, 2); ?></td>
                    <td><?php echo number_format($interest_c, 2); ?></td>
                    <td><?php echo number_format($balance, 2); ?></td>
                </tr>
            <?php endfor; ?>
            </tbody>
        </table>
    <?php else: ?>
        <?php echo $this->Session->flash(); ?>
        <div class="jumbotron">
            <h1>Calculate interest rates by Effective rate</h1>
            <h3>Place enter information in left side</h3>
            <small>This project used CakePHP framework (v2.5.7) is MVC frameword and used Bootstrap 3 framework is HTML, CSS, and JS framework</small>
        </div>
    <?php endif; ?>
</div><!-- /.main -->