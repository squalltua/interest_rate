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
        'type' => 'float', 
        'placeholder' => '3.5',
        'required' => true
    )); ?>
    <br/>
    <?php echo $this->Form->end('Calulate'); ?>
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
    <?php endif; ?>
</div><!-- /.main -->